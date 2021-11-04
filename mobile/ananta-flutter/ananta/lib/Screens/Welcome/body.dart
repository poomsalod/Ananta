import 'package:ananta/Screens/Home/home.dart';
import 'package:ananta/Screens/Home/tab/details/details.dart';
import 'package:ananta/Screens/Login/login.dart';
import 'package:ananta/Screens/Signup/signup.dart';
import 'package:ananta/Screens/Test/test.dart';
import 'package:ananta/Screens/Test/testFuture.dart';
import 'package:ananta/Screens/Test/testOneFood.dart';
import 'package:ananta/Services/api.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/components/rounded_button.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class WelcomeScreen1 extends StatefulWidget {
  const WelcomeScreen1({Key? key}) : super(key: key);

  @override
  _WelcomeScreen1State createState() => _WelcomeScreen1State();
}

class _WelcomeScreen1State extends State<WelcomeScreen1> {
  final storage = new FlutterSecureStorage();

  @override
  void initState() {
    super.initState();
    readToken();
  }

  Future<Null> readToken() async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      Provider.of<Auth>(context, listen: false)
          .tryToken(token: token == null ? '' : token);
    });
  }

  // void readToken() async {
  //   String token = '';
  //   token = (await storage.read(key: 'token'))!;
  //   print(token);
  //   Provider.of<Auth>(context, listen: false).tryToken(token: token);
  // }

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    // This size provide us total height and width of our screen
    return Center(child: Consumer<Auth>(
      builder: (context, auth, child) {
        if (!auth.authenticated) {
          return Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Text(
                "WELCOME TO EDU",
                style: TextStyle(fontWeight: FontWeight.bold),
              ),
              SizedBox(height: size.height * 0.05),
              SizedBox(height: size.height * 0.05),
              RoundedButton(
                text: "LOGIN",
                press: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) {
                        return LoginScreen();
                      },
                    ),
                  );
                },
              ),
              RoundedButton(
                text: "LOGOUT",
                press: () {
                  Provider.of<Auth>(context, listen: false).logout();
                },
              ),
              RoundedButton(
                text: "SIGN UP",
                color: kPrimaryLightColor,
                textColor: Colors.black,
                press: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) {
                        return SignUpScreen();
                      },
                    ),
                  );
                },
              ),
            ],
          );
        } else {
          return Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Text(
                "WELCOME TO EDU",
                style: TextStyle(fontWeight: FontWeight.bold),
              ),
              SizedBox(height: size.height * 0.05),
              SizedBox(height: size.height * 0.05),
              RoundedButton(
                text: "HOME",
                press: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) {
                        return HomeScreen();
                      },
                    ),
                  );
                },
              ),
              // RoundedButton(
              //   text: "TEST",
              //   press: () {
              //     Navigator.push(
              //       context,
              //       MaterialPageRoute(
              //         builder: (context) {
              //           return TestScreen();
              //         },
              //       ),
              //     );
              //   },
              // ),
              // RoundedButton(
              //   text: "detial",
              //   press: () {
              //     // Navigator.push(
              //     //   context,
              //     //   MaterialPageRoute(
              //     //     builder: (context) {
              //     //       return FoodDetails();
              //     //     },
              //     //   ),
              //     // );
              //   },
              // ),
              // RoundedButton(
              //   text: "future",
              //   press: () {
              //     Navigator.push(
              //       context,
              //       MaterialPageRoute(
              //         builder: (context) {
              //           return TestOneFoodScreen();
              //         },
              //       ),
              //     );
              //   },
              // ),
              // RoundedButton(
              //   text: "run",
              //   press: () {
              //     FoodAllApiTest.getFood();
              //   },
              // ),
              RoundedButton(
                text: "LOGOUT",
                press: () {
                  Provider.of<Auth>(context, listen: false).logout();
                },
              ),
            ],
          );
        }
      },
    ));
  }
}
