from flask import Flask, request, render_template
import numpy as np
import pickle
import joblib
from sklearn.preprocessing import StandardScaler

app = Flask(__name__, template_folder='template')

# Load the pre-trained model

model_symptom = pickle.load(open('model_symptom.pkl', 'rb'))
model_demo = pickle.load(open('model_demo.pkl', 'rb'))

# Load scalar model
scaler_symptom = joblib.load('scalar_symptom.pkl')
scaler_demo = joblib.load('scalar_demo.pkl')


@app.route("/")
def index():
    return render_template("index.html")


@app.route("/predict", methods=["POST", 'GET'])
def predict():
    # Get the input values from the form
    Age = int(request.form["age"])
    Gender = request.form["gender"]
    Frequent_Urination = request.form["frequent_urination"]
    Frequent_Thirst = request.form["frequent_thirst"]
    Weakness = request.form["weakness"]
    Excessive_Eating = request.form["excessive_eating"]
    Delayed_Healing = request.form["delayed_healing"]
    Partial_Paresis = request.form["partial_paresis"]
    Blood_Pressure = request.form["blood_pressure"]
    Family_History = request.form["family_history"]
    Height_cm = float(request.form["height"])
    Weight_kg = float(request.form["weight"])

    # converting 'Frequent_Urination','Frequent_Thirst','Weakness','Excessive_Eating','Delayed_Healing','Partial_Paresis'
    # into binary
    dic_var = {'Frequent_Urination': Frequent_Urination,
               'Frequent_Thirst': Frequent_Thirst,
               'Weakness': Weakness,
               'Excessive_Eating': Excessive_Eating,
               'Delayed_Healing': Delayed_Healing,
               'Partial_Paresis': Partial_Paresis,
               'Blood_Pressure': Blood_Pressure,
               'Family_History': Family_History}

    # converting Gender into binary
    if Gender == 'Female':
        Gender = 1
    else:
        Gender = 0

    # Calculating BMI
    height_m = Height_cm / 100
    BMI = round(Weight_kg / (height_m ** 2))

    # create an empty array of integers
    user_symptom = np.array([], dtype=int)
    user_demo = np.array([], dtype=int)
    # appending values
    user_symptom = np.append(user_symptom, [Age, Gender])
    user_demo = np.append(user_demo, [Age, Gender])

    for k in dic_var.keys():
        if (k != 'Blood_Pressure' and k != 'Family_History'):
            if dic_var[k] == 'Yes':
                dic_var[k] = 1
            else:
                dic_var[k] = 0
            user_symptom = np.append(user_symptom, dic_var[k])
        else:
            if dic_var[k] == 'Yes':
                dic_var[k] = 1
            else:
                dic_var[k] = 0
            user_demo = np.append(user_demo, dic_var[k])

    user_demo = np.append(user_demo, BMI)

    # user input dataset1
    # 'Age','Gender','Frequent_Urination','Frequent_Thirst','Weakness','Excessive_Eating','Delayed_Healing','Partial_Paresis']]
    user_symptom = user_symptom.reshape(1, -1)

    # user input dataset2
    # Age,Gender,Blood_Pressure,Family_History,BMI
    user_demo = user_demo.reshape(1, -1)

    # user input dataset 3
    #

    # apply the scaler on the input array
    user_symptom_scaled = scaler_symptom.transform(user_symptom)
    user_demo_scaled = scaler_demo.transform(user_demo)

    # prediction
    pred_user_symptom = model_symptom.predict(user_symptom_scaled)
    pred_user_demo = model_demo.predict(user_demo_scaled)
    final_prediction = round((pred_user_demo[0] + pred_user_symptom[0][1] * 100) / 2,2)

    # Convert the prediction to a string
    if final_prediction < 50:
        prediction_text = "Based on the prediction the probability of this person having diabetes is lower"
    else:
        prediction_text = "Based on the prediction the probability of this person having diabetes is higher"

    # Convert the prediction to a string
    final_prediction_str = str(final_prediction)

    # Concatenate the string prediction_text and final_prediction_str
    result = "<p>" + final_prediction_str + ", " + prediction_text + "</p>"

    # Render the index.html template with the prediction result
    return result


if __name__ == "__main__":
    app.run(debug=True)
