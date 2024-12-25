import tensorflow as tf
import numpy as np
import requests
import json
from celery import Celery

app = Celery('distributed_ai', broker='redis://localhost:6379/0')

def send_data_to_server(data):
    result = train_on_user_data.delay(data)
    return result

def generate_training_data():
    # temp test
    x_train = np.random.rand(100, 10)
    y_train = np.random.randint(0, 10, size=100)
    return list(zip(x_train.tolist(), y_train.tolist()))

if __name__ == '__main__':
    data = generate_training_data()
    result = send_data_to_server(data)
    print(f'Sent task id: {result.id}')
