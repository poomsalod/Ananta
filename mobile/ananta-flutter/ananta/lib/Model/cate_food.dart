import 'dart:convert';

List<CateFoodModel> cateFoodModelFromJson(String str) =>
    List<CateFoodModel>.from(
        json.decode(str).map((x) => CateFoodModel.fromJson(x)));

String cateFoodModelToJson(List<CateFoodModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class CateFoodModel {
  CateFoodModel({
    required this.cateFoodId,
    required this.name,
  });

  int cateFoodId;
  String name;

  factory CateFoodModel.fromJson(Map<String, dynamic> json) => CateFoodModel(
        cateFoodId: json["cate_food_id"],
        name: json["name"],
      );

  Map<String, dynamic> toJson() => {
        "cate_food_id": cateFoodId,
        "name": name,
      };
}
