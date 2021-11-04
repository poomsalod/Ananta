import 'package:flutter/material.dart';

class BoxProfile2 extends StatelessWidget {
  String tdee;
  String bmr;
  String bmi;

  BoxProfile2({
    Key? key,
    required this.tdee,
    required this.bmr,
    required this.bmi,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(1.0),
      child: Column(
        children: [
          Card(
            clipBehavior: Clip.antiAlias,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(10),
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'ข้อมูลโภชนาการ',
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      SizedBox(
                        height: 12,
                      ),
                      profileData(title: 'ค่า BMI', value: bmi + ' kg/m^2'),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'ค่า BMR', value: bmr + ' kcal'),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'ค่า TDEE', value: tdee + ' kcal'),
                      SizedBox(
                        height: 5,
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

Widget profileData({required String title, required String value}) {
  return Row(
    children: [
      Expanded(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
      Expanded(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
            Text(
              value,
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
    ],
  );
}
