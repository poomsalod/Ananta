import 'dart:convert';

DayEatModel dayEatModelFromJson(String str) =>
    DayEatModel.fromJson(json.decode(str));

String dayEatModelToJson(DayEatModel data) => json.encode(data.toJson());

class DayEatModel {
  DayEatModel({
    required this.tdee,
    required this.dayEat,
  });

  int tdee;
  int dayEat;

  factory DayEatModel.fromJson(Map<String, dynamic> json) => DayEatModel(
        tdee: json["tdee"],
        dayEat: json["dayEat"],
      );

  Map<String, dynamic> toJson() => {
        "tdee": tdee,
        "dayEat": dayEat,
      };
}
