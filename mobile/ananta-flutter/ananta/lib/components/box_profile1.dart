import 'package:flutter/material.dart';

class BoxProfile1 extends StatelessWidget {
  String name;
  String gender;
  String w;
  String h;
  String ac;
  String bDate;
  String image;

  BoxProfile1({
    Key? key,
    required this.name,
    required this.gender,
    required this.w,
    required this.h,
    required this.ac,
    required this.bDate,
    required this.image,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(1.0),
      child: Column(
        children: [
          Card(
            color: Colors.grey[200],
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
                      Center(
                        child: CircleAvatar(
                          radius: 64,
                          backgroundColor: Colors.white,
                          child: CircleAvatar(
                            radius: 60,
                            backgroundImage: NetworkImage(image),
                            // child: Text('I'),
                            // backgroundImage:
                            //     AssetImage('assets/images/poom.jpg'),
                          ),
                        ),
                      ),
                      // Text(
                      //   'ข้อมูลส่วนตัว',
                      //   style: TextStyle(
                      //     fontSize: 20,
                      //     fontWeight: FontWeight.bold,
                      //   ),
                      // ),
                      SizedBox(
                        height: 12,
                      ),
                      profileData(title: 'ชื่อ', value: name),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'เพศ', value: gender),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'น้ำหนัก', value: w),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'ส่วนสูง', value: h),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'กิจกรรมที่ทำต่อสัปดาห์', value: ac),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      SizedBox(
                        height: 5,
                      ),
                      profileData(title: 'วันเกิด', value: bDate),
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
    mainAxisAlignment: MainAxisAlignment.end,
    crossAxisAlignment: CrossAxisAlignment.end,
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
