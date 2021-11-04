import 'dart:io';
import 'package:ananta/Model/dayEat.dart';
import 'package:ananta/Model/history.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class History extends ChangeNotifier {
  List<HistoryModel> history = [];
  List<DayEatModel> dayEat = [];

  List<HistoryModel> gethistory() {
    return history;
  }

  addhistory(HistoryModel item) {
    history.add(item);
  }

  List<DayEatModel> getdayEat() {
    return dayEat;
  }

  adddayEat(DayEatModel item) {
    dayEat.add(item);
  }

  void fetchHistory({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        history = [];
        dayEat = [];

        Map creds = {'id': userId.toString()};
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/history'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        Iterable list = json.decode(response.body);
        history = list.map((model) => HistoryModel.fromJson(model)).toList();
        print('history ok');

        final response2 =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/dayeat'),
                // Send authorization headers to the backend.
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        dayEat.add(DayEatModel.fromJson(json.decode(response2.body)));
        print('dayEat ok');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
