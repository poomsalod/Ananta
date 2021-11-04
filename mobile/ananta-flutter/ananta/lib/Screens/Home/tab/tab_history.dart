import 'package:ananta/Model/dayEat.dart';
import 'package:ananta/Model/history.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/hisyory.dart';
import 'package:ananta/components/box_dayEat.dart';
import 'package:ananta/components/box_history.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class HistoryTab extends StatefulWidget {
  const HistoryTab({Key? key}) : super(key: key);

  @override
  _HistoryTabState createState() => _HistoryTabState();
}

class _HistoryTabState extends State<HistoryTab> {
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
      Provider.of<History>(context, listen: false)
          .fetchHistory(token: token == null ? '' : token, userId: userId);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Center(child: Consumer<History>(builder: (context, history, child) {
      if (history.history.length != 0) {
        DayEatModel dayEat = history.dayEat[0];
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            BoxDayEat(
              tdee: dayEat.tdee.toString(),
              dayEat: dayEat.dayEat.toString(),
            ),
            Padding(
              padding: const EdgeInsets.all(9.0),
              child: Text(
                'ประวัติการรับประทานทั้งหมด',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
            Expanded(
              child: ListView.builder(
                  itemCount: history.history.length,
                  itemBuilder: (context, int index) {
                    HistoryModel data = history.history[index];
                    // String image = 'http://10.0.2.2:8000/storage/images/food/' +
                    //     data.image;
                    // String image2 =
                    //     'http://www.anan-ta.online/storage/images/food/' +
                    //         data.image;
                    String imageUrl = baseUrlImage + '/food/' + data.image;
                    return BoxHistory(
                      image: imageUrl,
                      name: data.name,
                      date: data.date.toString(),
                      time: data.time,
                    );
                  }),
            ),
          ],
        );
      } else {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            BoxDayEat(
              tdee: '',
              dayEat: '',
            ),
            Padding(
              padding: const EdgeInsets.all(9.0),
              child: Text(
                'ประวัติการรับประทานทั้งหมด',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ],
        );
      }
    }));
  }
}
