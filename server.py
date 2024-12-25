
from celery import Celery
import tensorflow as tf
import numpy as np
app = Celery('distributed_ai', broker='redis://localhost:6379/0')

#trainai
def train_model_on_data(data):
    model = tf.keras.Sequential([
        tf.keras.layers.Dense(128, activation='relu', input_shape=(data.shape[1],)),
        tf.keras.layers.Dense(10, activation='softmax')
    ])
    model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    model.fit(data, epochs=5)
    return model.get_weights() 

# get tasj for ai
@app.task
def train_on_user_data(data):
    print("get data...")
    return train_model_on_data(np.array(data))

if __name__ == '__main__':
    app.start()
