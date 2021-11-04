import 'package:flutter/material.dart';

class CardCommonFood extends StatelessWidget {
  final String img;
  final String name;
  final String calorie;
  final String percentUserCook;
  final Function ontab;
  const CardCommonFood({
    Key? key,
    required this.img,
    required this.name,
    required this.calorie,
    required this.percentUserCook,
    required this.ontab,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(
        children: [
          Card(
            clipBehavior: Clip.antiAlias,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(24),
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Stack(
                  alignment: Alignment.center,
                  children: [
                    Ink.image(
                      image: NetworkImage(
                        img,
                      ),
                      child: InkWell(
                        onTap: () {
                          ontab();
                        },
                      ),
                      height: 240,
                      fit: BoxFit.cover,
                    ),
                  ],
                ),
                SizedBox(
                  height: 1,
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        name,
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      SizedBox(
                        height: 12,
                      ),
                      Row(
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  'ความพร้อม ' + percentUserCook + '%',
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
                                  'พลังงาน ' + calorie + ' kcal',
                                  style: TextStyle(
                                    fontSize: 14,
                                    fontWeight: FontWeight.normal,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
                ButtonBar(
                  alignment: MainAxisAlignment.start,
                  children: [
                    TextButton(
                      onPressed: () {
                        ontab();
                      },
                      child: Text('ดูรายละเพิ่มเติม'),
                    )
                  ],
                )
              ],
            ),
          ),
        ],
      ),
    );
  }
}
