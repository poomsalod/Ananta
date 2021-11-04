import 'dart:io';
import 'package:ananta/Model/food.dart';
import 'package:ananta/Model/igd_info.dart';
import 'package:ananta/Model/igd_of_food.dart';
import 'package:ananta/Model/rating.dart';
import 'package:ananta/Model/step_of_food.dart';
import 'package:flutter/cupertino.dart';
import 'package:ananta/Services/dio.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class FoodDetail extends ChangeNotifier {
  List<FoodModel> food = [];
  List<IgdOfFoodModel> igdOfFood = [];
  List<IgdInfoModel> igdInfo = [];
  List<StepOfFoodModel> stepOfFood = [];
  List<RatingModel> rating = [];

  List<FoodModel> getfood() {
    return food;
  }

  addfood(FoodModel item) {
    food.add(item);
  }

  List<IgdOfFoodModel> getigdOfFood() {
    return igdOfFood;
  }

  addigdOfFood(IgdOfFoodModel item) {
    igdOfFood.add(item);
  }

  List<IgdInfoModel> getigdInfo() {
    return igdInfo;
  }

  addOrderRecFood(IgdInfoModel item) {
    igdInfo.add(item);
  }

  List<StepOfFoodModel> getStepOfFood() {
    return stepOfFood;
  }

  addStepOfFood(StepOfFoodModel item) {
    stepOfFood.add(item);
  }

  List<RatingModel> getrating() {
    return rating;
  }

  addrating(RatingModel item) {
    rating.add(item);
  }

  void fetchFoodDetail(
      {required String token, required int foodId, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        food = [];
        igdOfFood = [];
        igdInfo = [];
        rating = [];

        Map creds = {'id': foodId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/onefood'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        food.add(FoodModel.fromJson(json.decode(response.body)));
        print('step 1 ok');

        final response2 =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/foodigd'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        Iterable list = json.decode(response2.body);
        igdOfFood =
            list.map((model) => IgdOfFoodModel.fromJson(model)).toList();
        print('step 2 ok');
        print(igdOfFood.length);

        for (int i = 0; i < igdOfFood.length; i++) {
          IgdOfFoodModel data = igdOfFood[i];
          Map creds3 = {'id': data.igdInfoId.toString()};
          final response3 =
              await http.post(Uri.parse('http://10.0.2.2:8000/api/igdinfo'),
                  // Send authorization headers to the backend.
                  headers: {
                    HttpHeaders.authorizationHeader: 'Bearer $token',
                  },
                  body: creds3);
          print('api ok');
          igdInfo.add(IgdInfoModel.fromJson(json.decode(response3.body)));
          print('igd_info $i OK');
        }

        final response4 =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/foodstep'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        Iterable list2 = json.decode(response4.body);
        stepOfFood =
            list2.map((model) => StepOfFoodModel.fromJson(model)).toList();
        print('step 4 ok');

        Map creds2 = {
          'user_id': userId.toString(),
          'food_id': foodId.toString(),
        };
        final response5 =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/getrating'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds2);

        print(response5.body);
        rating.add(RatingModel.fromJson(json.decode(response5.body)));

        print('rating ok');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchFood({required String token, required int foodId}) async {
    if (token == '') {
      return;
    } else {
      try {
        Map creds = {'id': foodId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/onefood'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        print(json.decode(response.body));
        // Iterable list = json.decode(response.body);
        // food = list.map((model) => FoodModel.fromJson(model)).toList();
        food.add(FoodModel.fromJson(json.decode(response.body)));
        print('food OK');
        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchIgdOfFood({required String token, required int foodId}) async {
    if (token == '') {
      return;
    } else {
      try {
        Map creds = {'id': foodId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/foodigd'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        Iterable list = json.decode(response.body);
        igdOfFood =
            list.map((model) => IgdOfFoodModel.fromJson(model)).toList();
        print('igd_of_food OK');
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchIgdInfo({required String token, required int igdId}) async {
    if (token == '') {
      return;
    } else {
      try {
        Map creds = {'id': igdId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/igdinfo'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        // Iterable list = json.decode(response.body);
        // igdInfo = list.map((model) => IgdInfoModel.fromJson(model)).toList();
        igdInfo.add(IgdInfoModel.fromJson(json.decode(response.body)));
      } catch (e) {
        print(e);
      }
    }
  }
}
