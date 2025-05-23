from flask import Flask, request, jsonify
from models.trie import Trie
from models.model import Model
from utils.helper import load_responses, extract_ip_addresses
app = Flask(__name__)
response_data = load_responses()
response_trie = Trie()
for ip, data in response_data.items():
    response_trie.insert(ip, data)

@app.route('/chat', methods=['POST'])
def chat():
    user_input = request.json.get('message')
    response = get_response(user_input)
    
    return jsonify({"response": response})

def get_response(user_input):
    ip_addresses = extract_ip_addresses(user_input)

    if ip_addresses:
        responses = [response_trie.search(ip) for ip in ip_addresses]
        return [response for response in responses if response] or ["No information found for the provided IP address."]
    
    return "Please provide a valid IP address."

if __name__ == '__main__':
    app.run(debug=True)
