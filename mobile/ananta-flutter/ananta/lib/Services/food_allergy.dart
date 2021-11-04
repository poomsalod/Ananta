import 'dart:io';

import 'package:ananta/Model/cate_igd.dart';
import 'package:ananta/Model/igd_for_allergy.dart';

import 'package:flutter/cupertino.dart';
import 'package:ananta/Services/dio.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class FoodAllergy extends ChangeNotifier {
  List<IgdModal> igd = [];
  List<IgdModal> igdAllergy = [];
  List<CateIgdModel> orderCateIgd = [];

  List<IgdModal> getigd() {
    return igd;
  }

  addigd(IgdModal item) {
    igd.add(item);
  }

  List<IgdModal> getigdAllergy() {
    return igd;
  }

  addigdAllergy(IgdModal item) {
    igdAllergy.add(item);
  }

  List<CateIgdModel> getOrderCateIgd() {
    return orderCateIgd;
  }

  addOrderCateIgd(CateIgdModel item) {
    orderCateIgd.add(item);
  }

  void fetchigd({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        igd = [];
        Map creds = {'user_id': userId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/getigd'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        print(json.decode(response.body));

        Iterable list = json.decode(response.body);
        igd = list.map((model) => IgdModal.fromJson(model)).toList();

        print('igd OK');

        orderCateIgd = [];
        final response2 = await http.get(
          Uri.parse('http://10.0.2.2:8000/api/cateigd'),
          // Send authorization headers to the backend.
          headers: {
            HttpHeaders.authorizationHeader: 'Bearer $token',
          },
        );

        Iterable list2 = json.decode(response2.body);
        orderCateIgd =
            list2.map((model) => CateIgdModel.fromJson(model)).toList();
        print('cate OK');
        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void fetchFoodAllergy({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        igdAllergy = [];
        Map creds = {'user_id': userId.toString()};
        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/getfoodallergy'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);
        print(json.decode(response.body));

        Iterable list = json.decode(response.body);
        igdAllergy = list.map((model) => IgdModal.fromJson(model)).toList();

        print('igd OK');
        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void addFoodAllergy(
      {required String token, required int userId, required int igdId}) async {
    if (token == '') {
      return;
    } else {
      try {
        igd = [];
        Map creds = {
          'user_id': userId.toString(),
          'igd_info_id': igdId.toString(),
        };
        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/addfoodallergy'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);
        print(json.decode(response.body));

        print('addFoodAllergy OK');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void deleteFoodAllergy(
      {required String token, required int userId, required int igdId}) async {
    if (token == '') {
      return;
    } else {
      try {
        Map creds = {
          'user_id': userId.toString(),
          'igd_info_id': igdId.toString(),
        };
        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/deletefoodallergy'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);

        print('deleteFoodAllergy OK');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
