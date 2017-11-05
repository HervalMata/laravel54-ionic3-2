import {Component} from '@angular/core';
import {IonicPage, NavController, NavParams} from 'ionic-angular';
import 'rxjs/add/operator/toPromise';
import {AuthProvider} from "../../providers/auth";

/**
 * Generated class for the LoginPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {

  private email: string = 'admin@user.com';
  private password: string = 'secret';

  constructor(public navCtrl: NavController,
              public navParams: NavParams,
              private auth: AuthProvider
  ) {
    //componente ---> template    - property binding
    //templante  ---> componente  - property binding
    //componente <---> templante  - two-way data-binding
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }

  login() {
    /*
    this.jwtClient.access_token({email: this.email, password: this.password})
      .then((token) => {
        console.log(token);
      });
    */
    //this.email = 'carlosanders@gmail.com';
    //this.password = '1234678';
    // this.http.post('http://localhost:8000/api/access_token',{
    //   email: this.email,
    //   password: this.password
    // }).toPromise() //promessa pode dar certo ou dar erro
    //   //entao caso de certo
    //   .then((response) =>{
    //     console.log(response);
    //   });
  }

}
