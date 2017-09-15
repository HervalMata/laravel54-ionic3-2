import { Injectable } from '@angular/core';
import {Http, Response} from '@angular/http';
import 'rxjs/add/operator/map';
import {JwtCredentials} from "../../models/jwt-credentials";

/*
  Generated class for the JwtClientProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class JwtClientProvider {

  constructor(public http: Http) {
    console.log('Hello JwtClientProvider Provider');
  }

  access_token(jwtCredentials: JwtCredentials): Promise<string>{
    return this.http.post('http://localhost:8000/api/access_token',jwtCredentials)
        .toPromise() //promessa pode dar certo ou dar erro
    //entao caso de certo
      .then((response: Response) =>{
        //console.log(response);
        let token = response.json().token;
        return token;
      });
  }

}
