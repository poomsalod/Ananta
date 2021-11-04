import 'package:ananta/Model/dayEat.dart';
import 'package:ananta/Model/history.dart';
import 'package:ananta/Model/nutrition.dart';
import 'package:ananta/Model/profile.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/hisyory.dart';
import 'package:ananta/Services/nutrition.dart';
import 'package:ananta/components/box_dayEat.dart';
import 'package:ananta/components/box_history.dart';
import 'package:ananta/components/box_profile1.dart';
import 'package:ananta/components/box_profile2.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class ProfileTab extends StatefulWidget {
  const ProfileTab({Key? key}) : super(key: key);

  @override
  _ProfileTabState createState() => _ProfileTabState();
}

class _ProfileTabState extends State<ProfileTab> {
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
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<NutritionPro>(context, listen: false)
          .fetchNutrition(token: token == null ? '' : token, userId: userId);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Consumer<NutritionPro>(builder: (context, nutrition, child) {
        if (nutrition.nutri.length != 0) {
          Nutrition data = nutrition.nutri[0];
          final Profile user_profile =
              Provider.of<Auth>(context, listen: false).profile;

          String gender = '';
          if (data.gender == 1) {
            gender = 'ชาย';
          } else {
            gender = 'หญิง';
          }
          String ac = '';
          List atv = [1.2, 1.375, 1.55, 1.725, 1.9];
          List atvname = [
            'ไม่ออกกำลังกายหรือทำงานนั่งโต๊ะ',
            'ออกกำลังกายเบาๆ(1-2 ครั้งต่อสัปดาห์ )',
            'ออกกำลังกายปานกลาง(3-5 ครั้งต่อสัปดาห์)',
            'ออกกำลังกายหนัก(6-7 ครั้งต่อสัปดาห์)',
            'ออกกำลังกายหนักมาก(ทุกวัน วันละ 2 เวลา)'
          ];
          for (int i = 0; i < atv.length; i++) {
            if (data.activity == atv[i]) {
              ac = atvname[i];
            }
          }
          String imageUrl = baseUrlImage + '/user/' + user_profile.image;
          return Column(
            mainAxisAlignment: MainAxisAlignment.start,
            children: [
              BoxProfile1(
                name: user_profile.f_name + ' ' + user_profile.l_name,
                gender: gender,
                w: data.weight.toString() + ' ก.ก.',
                h: data.height.toString() + ' ซ.ม.',
                ac: ac,
                bDate: user_profile.birthday,
                image: imageUrl,
              ),
              BoxProfile2(
                tdee: data.tdee.toInt().toString(),
                bmr: data.bmr.toInt().toString(),
                bmi: data.bmi.toInt().toString(),
              ),
            ],
          );
        } else {
          return Center(child: CircularProgressIndicator());
        }
      }),
    );
  }
}
