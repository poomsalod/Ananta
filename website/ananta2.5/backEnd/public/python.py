#!/usr/bin/env python
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import os
import warnings

warnings.filterwarnings('ignore')
import tensorflow.keras as tf

print("TrendOceans")
print(tf.__version__)

ratings_df = pd.read_csv("ratingfood.csv") 
books_df = pd.read_csv("food.csv")

from sklearn.model_selection import train_test_split
Xtrain, Xtest = train_test_split(ratings_df, test_size=0.2, random_state=1)

nbook_id = ratings_df.food_id.nunique()
nuser_id = ratings_df.user_id.nunique()

input_books = tf.layers.Input(shape=[1])
embed_books = tf.layers.Embedding(nbook_id + 1,15)(input_books)
books_out = tf.layers.Flatten()(embed_books)

#user input network
input_users = tf.layers.Input(shape=[1])
embed_users = tf.layers.Embedding(nuser_id + 1,15)(input_users)
users_out = tf.layers.Flatten()(embed_users)

conc_layer = tf.layers.Concatenate()([books_out, users_out])
x = tf.layers.Dense(128, activation='relu')(conc_layer)
x_out = x = tf.layers.Dense(1, activation='relu')(x)
model = tf.Model([input_books, input_users], x_out)

opt = tf.optimizers.Adam(learning_rate=0.001)
model.compile(optimizer=opt, loss='mean_squared_error')

hist = model.fit([Xtrain.food_id, Xtrain.user_id], Xtrain.rating, 
                 batch_size=64, 
                 epochs=5, 
                 verbose=1,
                 )

print('111111111')

book_em = model.get_layer('embedding')
book_em_weights = book_em.get_weights()[0]
book_em_weights.shape

print('2222222222')

books_df_copy = books_df.copy()
books_df_copy['food_id_1'] = books_df_copy['food_id']
books_df_copy = books_df_copy.set_index("food_id")

print('3333333333')

b_id =list(ratings_df.food_id.unique())
b_id.remove(40)
book_arr = np.array(b_id) #get all book IDs
user = np.array([6 for i in range(len(b_id))])
pred = model.predict([book_arr, user])

print('4444444444')

pred = pred.reshape(-1) #reshape เป็นมิติเดียว
pred_ids = (-pred).argsort()[0:5] 


print(books_df.iloc[pred_ids])
print("successssssss")