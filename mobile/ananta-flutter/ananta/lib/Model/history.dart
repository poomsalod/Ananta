import 'dart:convert';

List<HistoryModel> historyModelFromJson(String str) => List<HistoryModel>.from(
    json.decode(str).map((x) => HistoryModel.fromJson(x)));

String historyModelToJson(List<HistoryModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class HistoryModel {
  HistoryModel({
    required this.name,
    required this.image,
    required this.calorie,
    required this.date,
    required this.time,
  });

  String name;
  String image;
  double calorie;
  String date;
  String time;

  factory HistoryModel.fromJson(Map<String, dynamic> json) => HistoryModel(
        name: json["name"],
        image: json["image"],
        calorie: json["calorie"].toDouble(),
        date: json["date"],
        // date: DateTime.parse(json["date"]),
        time: json["time"],
      );

  Map<String, dynamic> toJson() => {
        "name": name,
        "image": image,
        "calorie": calorie,
        "date": date,
        // "date":
        //     "${date.year.toString().padLeft(4, '0')}-${date.month.toString().padLeft(2, '0')}-${date.day.toString().padLeft(2, '0')}",
        "time": time,
      };
}
