import 'dart:io';

import 'package:ananta/Screens/Home/home.dart';
import 'package:ananta/Screens/Signup/signup.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/components/already_have_an_account_acheck.dart';
import 'package:ananta/components/rounded_button.dart';
import 'package:ananta/components/rounded_input_field.dart';
import 'package:ananta/components/rounded_password_field.dart';
import 'package:device_info/device_info.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class Body extends StatefulWidget {
  const Body({Key? key}) : super(key: key);

  @override
  _BodyState createState() => _BodyState();
}

class _BodyState extends State<Body> {
  TextEditingController _usernameController = TextEditingController();
  TextEditingController _passwordController = TextEditingController();
  final _formkey = GlobalKey<FormState>();
  //device info
  DeviceInfoPlugin deviceInfo = DeviceInfoPlugin();
  String _deviceName = '';

  final storage = new FlutterSecureStorage();

  Future<Null> readToken() async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      Provider.of<Auth>(context, listen: false)
          .tryToken(token: token == null ? '' : token);
    });
  }

  @override
  void initState() {
    readToken();
    getDeviceName();
    super.initState();
  }

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  void getDeviceName() async {
    try {
      if (Platform.isAndroid) {
        AndroidDeviceInfo androidInfo = await deviceInfo.androidInfo;
        _deviceName = androidInfo.model;
      } else if (Platform.isIOS) {
        IosDeviceInfo iosInfo = await deviceInfo.iosInfo;
        _deviceName = iosInfo.utsname.machine;
      }
    } catch (e) {
      print(e);
    }
  }

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return Center(child: Consumer<Auth>(
      builder: (context, auth, child) {
        if (!auth.authenticated) {
          return Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [Color(0xFFFFD691), Color(0xFFFFF6E8)],
                begin: Alignment.bottomCenter,
                end: Alignment.topCenter,
              ),
            ),
            child: Form(
              key: _formkey,
              child: Center(
                child: SingleChildScrollView(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Image.asset(
                        'assets/images/logo_ananta2.png',
                        width: 320,
                      ),

                      SizedBox(height: size.height * 0.10),
                      RoundedInputField(
                        controller: _usernameController,
                        hintText: "บัญชีผู้ใช้",
                        icon: Icons.person,
                      ),
                      RoundedPasswordField(
                        controller: _passwordController,
                        hintText: 'รหัสผ่าน',
                      ),
                      RoundedButton(
                        text: "LOGIN",
                        press: () {
                          Map creds = {
                            'username': _usernameController.text,
                            'password': _passwordController.text,
                            'device_name':
                                _deviceName != '' ? _deviceName : 'unknown',
                          };
                          if (_formkey.currentState!.validate()) {
                            Provider.of<Auth>(context, listen: false)
                                .login(creds: creds);
                            Navigator.pop(context);
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return HomeScreen();
                                },
                              ),
                            );
                          }
                        },
                      ),
                      SizedBox(height: size.height * 0.03),
                      // AlreadyHaveAnAccountCheck(
                      //   press: () {
                      //     Navigator.push(
                      //       context,
                      //       MaterialPageRoute(
                      //         builder: (context) {
                      //           return SignUpScreen();
                      //         },
                      //       ),
                      //     );
                      //   },
                      // ),
                    ],
                  ),
                ),
              ),
            ),
          );
        } else {
          return HomeScreen();
        }
      },
    ));
  }
}
