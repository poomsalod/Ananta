import 'package:flutter/material.dart';

class BoxHistory extends StatelessWidget {
  String image;
  String name;
  String date;
  String time;
  BoxHistory({
    Key? key,
    required this.image,
    required this.name,
    required this.date,
    required this.time,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(1.0),
      child: Card(
        clipBehavior: Clip.antiAlias,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(10),
        ),
        child: Padding(
          padding: const EdgeInsets.all(8.0),
          child: Row(
            children: [
              buildCircleImage(
                image: NetworkImage(image),
              ),
              SizedBox(
                width: 5,
              ),
              Text(name),
              SizedBox(
                width: 5,
              ),
              Expanded(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.end,
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    Text(date),
                    Text(time),
                  ],
                ),
              ),
              // Expanded(
              //   child: Column(
              //     mainAxisAlignment: MainAxisAlignment.end,
              //     crossAxisAlignment: CrossAxisAlignment.end,
              //     children: [
              //       Text(time),
              //     ],
              //   ),
              // ),
            ],
          ),
        ),
      ),
    );
  }
}

Widget buildCircleImage({
  required ImageProvider image,
}) =>
    CircleAvatar(
      backgroundColor: Colors.grey[300],
      radius: 28,
      child: CircleAvatar(
        backgroundColor: Colors.grey[50],
        backgroundImage: image,
        foregroundColor: Colors.white,
        radius: 24,
        onBackgroundImageError: image != null
            ? (e, stackTrace) {
                print('e: ${e}');
              }
            : null,
        child: image == null
            ? Text(
                'I',
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 32),
              )
            : Container(height: 0, width: 0),
      ),
    );
