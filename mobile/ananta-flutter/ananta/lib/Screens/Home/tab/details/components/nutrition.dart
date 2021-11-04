import 'package:flutter/material.dart';

class NutritionBox extends StatelessWidget {
  final String data;
  const NutritionBox({
    Key? key,
    required this.data,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          SizedBox(
            width: 5,
          ),
          Text(
            data,
          ),
          SizedBox(
            width: 5,
          ),
        ],
      ),
    );
  }
}
