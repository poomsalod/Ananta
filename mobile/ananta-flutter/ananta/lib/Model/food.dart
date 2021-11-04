class FoodModel {
  FoodModel({
    this.foodId = 0,
    this.name = '',
    this.image = '',
    this.cateFoodId = 0,
    this.calorie = 0,
    this.fat = 0,
    this.protein = 0,
    this.carbohydrate = 0,
    this.fiber = 0,
    this.status = 0,
    this.addess = '',
    this.adminId = 0,
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
  int status;
  String addess;
  int adminId;

  factory FoodModel.fromJson(Map<String, dynamic> json) => FoodModel(
        foodId: json["food_id"],
        name: json["name"],
        image: json["image"],
        cateFoodId: json["cate_food_id"],
        calorie: json["calorie"].toDouble(),
        fat: json["fat"].toDouble(),
        protein: json["protein"].toDouble(),
        carbohydrate: json["carbohydrate"].toDouble(),
        fiber: json["fiber"].toDouble(),
        status: json["status"],
        addess: json["addess"],
        adminId: json["admin_id"],
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
        "status": status,
        "addess": addess,
        "admin_id": adminId,
      };
}
