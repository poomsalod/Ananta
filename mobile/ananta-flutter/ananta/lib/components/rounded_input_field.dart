import 'package:ananta/components/text_field_container.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';

class RoundedInputField extends StatelessWidget {
  final String hintText;
  final IconData icon;

  final TextEditingController controller;
  const RoundedInputField({
    Key? key,
    this.hintText = '',
    required this.icon,
    required this.controller,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return TextFieldContainer(
      child: TextFormField(
        controller: controller,
        validator: (value) => value!.isEmpty ? 'กรุณาป้อนข้อมูล' : null,
        cursorColor: kPrimaryColor,
        decoration: InputDecoration(
          icon: Icon(
            icon,
            color: kPrimaryColor,
          ),
          hintText: hintText,
          border: InputBorder.none,
        ),
      ),
    );
  }
}
