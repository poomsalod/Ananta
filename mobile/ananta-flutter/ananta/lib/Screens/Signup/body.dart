import 'package:ananta/Screens/Login/login.dart';
import 'package:ananta/components/already_have_an_account_acheck.dart';
import 'package:ananta/components/rounded_button.dart';
import 'package:ananta/components/rounded_input_field.dart';
import 'package:ananta/components/rounded_password_field.dart';
import 'package:flutter/material.dart';

class Body extends StatefulWidget {
  const Body({Key? key}) : super(key: key);

  @override
  _BodyState createState() => _BodyState();
}

class _BodyState extends State<Body> {
  TextEditingController _fnameController = TextEditingController();
  TextEditingController _lnameController = TextEditingController();
  TextEditingController _emailController = TextEditingController();
  TextEditingController _birthdayController = TextEditingController();
  TextEditingController _usernameController = TextEditingController();
  TextEditingController _passwordController = TextEditingController();
  TextEditingController _passwordConfirmController = TextEditingController();
  final _formkey = GlobalKey<FormState>();

  @override
  void initState() {
    super.initState();
  }

  @override
  void dispose() {
    _fnameController.dispose();
    _lnameController.dispose();
    _emailController.dispose();
    _birthdayController.dispose();
    _usernameController.dispose();
    _passwordController.dispose();
    _passwordConfirmController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return Center(
      child: SingleChildScrollView(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              "SIGNUP",
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
            RoundedInputField(
              hintText: "ชื่อ",
              icon: Icons.data_usage,
              controller: _fnameController,
            ),
            RoundedInputField(
              hintText: "นามสกุล",
              icon: Icons.data_usage,
              controller: _lnameController,
            ),
            RoundedInputField(
              hintText: "อีเมล",
              icon: Icons.email,
              controller: _emailController,
            ),
            RoundedInputField(
              hintText: "วันเกิด",
              icon: Icons.date_range,
              controller: _birthdayController,
            ),
            RoundedInputField(
              hintText: "บัญชีผู้ใช้",
              icon: Icons.person,
              controller: _usernameController,
            ),
            RoundedPasswordField(
              hintText: "รหัสผ่าน",
              controller: _passwordController,
            ),
            RoundedPasswordField(
              hintText: "ยืนยัน รหัสผ่าน",
              controller: _passwordConfirmController,
            ),
            RoundedButton(
              text: "SIGNUP",
              press: () {},
            ),
            SizedBox(height: size.height * 0.03),
            AlreadyHaveAnAccountCheck(
              login: false,
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
          ],
        ),
      ),
    );
  }
}
