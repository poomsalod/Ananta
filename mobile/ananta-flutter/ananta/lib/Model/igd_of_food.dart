// To parse this JSON data, do
//
//     final igdOfFoodModel = igdOfFoodModelFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<IgdOfFoodModel> igdOfFoodModelFromJson(String str) =>
    List<IgdOfFoodModel>.from(
        json.decode(str).map((x) => IgdOfFoodModel.fromJson(x)));

String igdOfFoodModelToJson(List<IgdOfFoodModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class IgdOfFoodModel {
  IgdOfFoodModel({
    required this.igdOfFoodId,
    required this.foodId,
    required this.igdInfoId,
    required this.description,
    required this.value,
    required this.unit,
    required this.importance,
    required this.adminId,
    required this.createdAt,
    required this.updatedAt,
  });

  int igdOfFoodId;
  int foodId;
  int igdInfoId;
  String description;
  double value;
  String unit;
  int importance;
  int adminId;
  DateTime createdAt;
  DateTime updatedAt;

  factory IgdOfFoodModel.fromJson(Map<String, dynamic> json) => IgdOfFoodModel(
        igdOfFoodId: json["igd_of_food_id"],
        foodId: json["food_id"],
        igdInfoId: json["igd_info_id"],
        description: json["description"],
        value: json["value"].toDouble(),
        unit: json["unit"],
        importance: json["importance"],
        adminId: json["admin_id"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "igd_of_food_id": igdOfFoodId,
        "food_id": foodId,
        "igd_info_id": igdInfoId,
        "description": description,
        "value": value,
        "unit": unit,
        "importance": importance,
        "admin_id": adminId,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
