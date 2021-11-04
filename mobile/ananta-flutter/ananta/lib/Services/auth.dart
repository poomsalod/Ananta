import 'package:ananta/Model/profile.dart';
import 'package:ananta/Model/user.dart';
import 'package:ananta/Services/dio.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class Auth extends ChangeNotifier {
  bool _isLogdedIn = false;
  User _user = new User();
  Profile _profile = new Profile();
  String _token = '';
  bool get authenticated => _isLogdedIn;
  User get user => _user;
  Profile get profile => _profile;
  final storage = new FlutterSecureStorage();

  void login({required Map creds}) async {
    print(creds);

    try {
      Dio.Response response = await dio().post('/login', data: creds);
      print(response.data.toString());

      String token = response.data.toString();

      this.tryToken(token: token);

      _isLogdedIn = true;
      notifyListeners();
    } catch (e) {
      print(e);
    }
  }

  void tryToken({required String token}) async {
    if (token == '') {
      return;
    } else {
      try {
        Dio.Response response = await dio().get('/user',
            options: Dio.Options(headers: {'Authorization': 'Bearer $token'}));

        this._isLogdedIn = true;
        print(response.data);
        this._user = User.fromJson(response.data);
        this._token = token;
        print("user OK");

        Map creds = {
          'account_id': _user.account_id,
        };

        print(creds);
        Dio.Response response2 = await dio().post('/user/profile',
            data: creds,
            options: Dio.Options(headers: {'Authorization': 'Bearer $token'}));

        this._isLogdedIn = true;
        print(response2.data[0]);
        print("profile NO");
        this._profile = Profile.fromJson(response2.data[0]);
        print("profile OK");

        this.storeToken(token: token);

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void storeToken({required String token}) async {
    this.storage.write(key: 'token', value: token);
  }

  void logout() async {
    try {
      Dio.Response response = await dio().post('/logout',
          options: Dio.Options(headers: {'Authorization': 'Bearer $_token'}));
      cleanUp();
    } catch (e) {}
    notifyListeners();
  }

  void cleanUp() async {
    this._user = new User();
    this._profile = new Profile();
    this._isLogdedIn = false;
    this._token = '';
    await storage.delete(key: 'token');
    await storage.delete(key: 'token');
  }

  void getApiFood({required String token}) async {
    if (token == '') {
      return;
    } else {
      try {
        print(token);
        print('token OK');
        Dio.Response response = await dio().get('/allfood',
            options: Dio.Options(headers: {'Authorization': 'Bearer $token'}));
        print('api OK');
        print(response.data.toString());

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
