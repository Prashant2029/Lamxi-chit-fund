from flask import Flask, request, jsonify
import pickle
import numpy as np
import pandas as pd

app = Flask(__name__)

# Load the model
model = pickle.load(open('pipe.pkl', 'rb'))

@app.route('/')
def home():
    return "Welcome to the Loan Approval System!"

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    print(f"Received data: {data}")  # Log incoming data

    if 'input' in data:
        input_data = data['input']

        # Ensure input is a list of lists
        if not isinstance(input_data, list) or not all(isinstance(i, (list, tuple)) for i in input_data):
            input_data = [input_data]  # Convert single input to list of lists

        # Define column names
        column_names = ['no_of_dependents', 'education', 'self_employed', 'income_annum',
                        'loan_amount', 'loan_term', 'cibil_score', 'residential_assets_value',
                        'commercial_assets_value', 'luxury_assets_value', 'bank_asset_value']

        # Convert input to DataFrame
        input_df = pd.DataFrame(input_data, columns=column_names)

        print(f"Processed DataFrame:\n{input_df}")  # Log processed DataFrame

        # Make prediction using the model
        prediction = model.predict(input_df)
        print(prediction)
        return jsonify({'approval': int(prediction[0])})

    else:
        return jsonify({'error': 'Invalid input format'}), 400



if __name__ == '__main__':
    app.run(debug=True)
