import { Injectable } from '@angular/core';
import {Http, Response} from '@angular/http';
import 'rxjs/add/operator/map';
import {Storage} from "@ionic/storage";

import {JwtCredentials} from "../../models/jwt-credentials";

/*
  Generated class for the JwtClientProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class JwtClientProvider {

  private _token = null;

  constructor(public http: Http, public storage:Storage) {
    this.getToken().then((token)=>{
      console.log(token);
    });
  }

  getToken(): Promise<string>{

    return new Promise((resolve) => {
      if(this._token){
        resolve(this._token);
      }
      this.storage.get('token').then((token) => {
        this._token = token;
        resolve(this._token);
      });
    });


  }

  access_token(jwtCredentials: JwtCredentials): Promise<string>{
    return this.http.post('http://localhost:8000/api/access_token',jwtCredentials)
        .toPromise() //promessa pode dar certo ou dar erro
    //entao caso de certo
      .then((response: Response) =>{
        //console.log(response);
        let token = response.json().token;
        this._token = token;
        this.storage.set('token', this._token);

        return token;
      });
  }

}
