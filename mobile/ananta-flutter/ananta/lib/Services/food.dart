import 'dart:io';
import 'package:ananta/Model/cate_food.dart';
import 'package:ananta/Model/food_all.dart';
import 'package:ananta/Model/food_rec.dart';
import 'package:flutter/cupertino.dart';
import 'package:ananta/Services/dio.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class Food extends ChangeNotifier {
  List<FoodAllModel> orderFood = [];
  List<FoodRacommended> orderRecFood = [];
  List<CateFoodModel> orderCateFood = [];

  List<FoodAllModel> getOrderFood() {
    return orderFood;
  }

  List<FoodRacommended> getOrderRecFood() {
    return orderRecFood;
  }

  List<CateFoodModel> getOrderCateFood() {
    return orderCateFood;
  }

  addOrderFood(FoodAllModel item) {
    orderFood.add(item);
  }

  addOrderRecFood(FoodRacommended item) {
    orderRecFood.add(item);
  }

  addOrderCateFood(CateFoodModel item) {
    orderCateFood.add(item);
  }

  void fetchFood({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        print('fetchFood OK');
        print(token);
        print('token OK');
        Map creds = {'user_id': userId.toString()};
        if (orderFood.length == 0) {
          final response =
              await http.post(Uri.parse('http://10.0.2.2:8000/api/allfood'),
                  // Send authorization headers to the backend.
                  headers: {
                    HttpHeaders.authorizationHeader: 'Bearer $token',
                  },
                  body: creds);
          Iterable list = json.decode(response.body);
          orderFood =
              list.map((model) => FoodAllModel.fromJson(model)).toList();
          print('api OK');

          final response2 = await http.get(
            Uri.parse('http://10.0.2.2:8000/api/catefood'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
          );

          Iterable list2 = json.decode(response2.body);
          orderCateFood =
              list2.map((model) => CateFoodModel.fromJson(model)).toList();
          print('cate OK');

          notifyListeners();
        } else {
          print('food No');
        }
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchRecFood({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        print('fetchRecFood OK');
        print(token);
        print('token OK');
        Map creds = {'user_id': userId.toString()};
        print(creds);
        orderRecFood = [];
        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/food/recommend'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);
        Iterable list = json.decode(response.body);
        orderRecFood =
            list.map((model) => FoodRacommended.fromJson(model)).toList();
        print('apiRec OK');

        final response2 = await http.get(
          Uri.parse('http://10.0.2.2:8000/api/catefood'),
          // Send authorization headers to the backend.
          headers: {
            HttpHeaders.authorizationHeader: 'Bearer $token',
          },
        );

        Iterable list2 = json.decode(response2.body);
        orderCateFood =
            list2.map((model) => CateFoodModel.fromJson(model)).toList();
        print('cate OK');

        notifyListeners();

        // if (orderRecFood.length == 0) {
        //   final response = await http.post(
        //       Uri.parse('http://10.0.2.2:8000/api/food/recommend'),
        //       // Send authorization headers to the backend.
        //       headers: {
        //         HttpHeaders.authorizationHeader: 'Bearer $token',
        //       },
        //       body: creds);
        //   Iterable list = json.decode(response.body);
        //   orderRecFood =
        //       list.map((model) => FoodModel.fromJson(model)).toList();
        //   print('apiRec OK');

        //   notifyListeners();
        // } else {
        //   print('foodRec OK');
        // }
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchSearchRecFood(
      {required String token, required int userId, required int cateId}) async {
    if (token == '') {
      return;
    } else {
      try {
        print('fetchRecFood OK');
        print(token);
        print('token OK');
        Map creds = {
          'user_id': userId.toString(),
          'cate_food_id': cateId.toString(),
        };
        print(creds);
        orderRecFood = [];
        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/food/recommend'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);
        Iterable list = json.decode(response.body);
        orderRecFood =
            list.map((model) => FoodRacommended.fromJson(model)).toList();
        print('apiRec OK');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void getApiFood({required String token}) async {
    if (token == '') {
      return;
    } else {
      try {
        print(token);
        print('token OK');
        Dio.Response response = await dio().get('/allfood',
            options: Dio.Options(headers: {'Authorization': 'Bearer $token'}));
        print('api OK');
        print(response.data[100].toString());

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void addHistory({required Map creds}) async {
    print(creds);

    try {
      Dio.Response response = await dio().post('/add/history', data: creds);
      print(response.data.toString());

      notifyListeners();
    } catch (e) {
      print(e);
    }
  }
}
