import 'dart:io';

import 'package:ananta/Model/cate_igd.dart';
import 'package:ananta/Model/igd_for_allergy.dart';
import 'package:ananta/Model/stock.dart';

import 'package:flutter/cupertino.dart';
import 'package:ananta/Services/dio.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class Stock extends ChangeNotifier {
  List<IgdModal> igd = [];
  List<StockModel> igdStock = [];
  List<CateIgdModel> orderCateIgd = [];

  List<IgdModal> getigd() {
    return igd;
  }

  addigd(IgdModal item) {
    igd.add(item);
  }

  List<StockModel> getigdStock() {
    return igdStock;
  }

  addigdStock(StockModel item) {
    igdStock.add(item);
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
            await http.post(Uri.parse('http://10.0.2.2:8000/api/getigdstock'),
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

  void fetchStock({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        igdStock = [];
        Map creds = {'user_id': userId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/getstock'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        print(json.decode(response.body));

        Iterable list = json.decode(response.body);
        igdStock = list.map((model) => StockModel.fromJson(model)).toList();

        print('stock OK');
        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void addStock(
      {required String token,
      required int userId,
      required String value,
      required int igdId}) async {
    if (token == '') {
      return;
    } else {
      try {
        igd = [];
        Map creds = {
          'user_id': userId.toString(),
          'value': value,
          'igd_info_id': igdId.toString(),
        };
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/addstock'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        print(json.decode(response.body));

        print('addstock OK');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }

  void deleteStock(
      {required String token, required int userId, required int igdId}) async {
    if (token == '') {
      return;
    } else {
      try {
        Map creds = {
          'user_id': userId.toString(),
          'igd_info_id': igdId.toString(),
        };
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/deletestock'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);

        print('deleteStock OK');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
