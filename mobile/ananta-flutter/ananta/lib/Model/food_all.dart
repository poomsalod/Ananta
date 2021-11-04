import 'dart:convert';

List<FoodAllModel> foodAllModelFromJson(String str) => List<FoodAllModel>.from(
    json.decode(str).map((x) => FoodAllModel.fromJson(x)));

String foodAllModelToJson(List<FoodAllModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class FoodAllModel {
  FoodAllModel({
    required this.foodId,
    required this.name,
    required this.image,
    required this.cateFoodId,
    required this.calorie,
    required this.fat,
    required this.protein,
    required this.carbohydrate,
    required this.fiber,
    required this.percentUserCook,
  });

  int foodId;
  String name;
  String image;
  int cateFoodId;
  double calorie;
  double fat;
  double protein;
  double carbohydrate;
  double fiber;
  int percentUserCook;

  factory FoodAllModel.fromJson(Map<String, dynamic> json) => FoodAllModel(
        foodId: json["food_id"],
        name: json["name"],
        image: json["image"],
        cateFoodId: json["cate_food_id"],
        calorie: json["calorie"].toDouble(),
        fat: json["fat"].toDouble(),
        protein: json["protein"].toDouble(),
        carbohydrate: json["carbohydrate"].toDouble(),
        fiber: json["fiber"].toDouble(),
        percentUserCook: json["percent_user_cook"],
      );

  Map<String, dynamic> toJson() => {
        "food_id": foodId,
        "name": name,
        "image": image,
        "cate_food_id": cateFoodId,
        "calorie": calorie,
        "fat": fat,
        "protein": protein,
        "carbohydrate": carbohydrate,
        "fiber": fiber,
        "percent_user_cook": percentUserCook,
      };
}
