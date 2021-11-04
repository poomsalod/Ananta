import 'dart:convert';

List<StepOfFoodModel> stepOfFoodModelFromJson(String str) =>
    List<StepOfFoodModel>.from(
        json.decode(str).map((x) => StepOfFoodModel.fromJson(x)));

String stepOfFoodModelToJson(List<StepOfFoodModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class StepOfFoodModel {
  StepOfFoodModel({
    required this.stepOfFoodId,
    required this.foodId,
    required this.order,
    required this.step,
    required this.adminId,
    required this.createdAt,
    required this.updatedAt,
  });

  int stepOfFoodId;
  int foodId;
  int order;
  String step;
  int adminId;
  DateTime createdAt;
  DateTime updatedAt;

  factory StepOfFoodModel.fromJson(Map<String, dynamic> json) =>
      StepOfFoodModel(
        stepOfFoodId: json["step_of_food_id"],
        foodId: json["food_id"],
        order: json["order"],
        step: json["step"],
        adminId: json["admin_id"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "step_of_food_id": stepOfFoodId,
        "food_id": foodId,
        "order": order,
        "step": step,
        "admin_id": adminId,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
