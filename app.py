from flask import Flask, render_template, request, redirect, url_for, session
import pandas as pd

app = Flask(__name__)
app.secret_key = "lumen-secret"  # Needed for session handling

# Load chatbot response dictionary
df = pd.read_csv('chatbot_dataset.csv', encoding='windows-1252')
df.columns = [col.strip().lower().replace(' ', '_') for col in df.columns]
responses_dict = {row['user_input'].strip().lower(): row['bot_response'] for _, row in df.iterrows()}

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/login')
def login():
    return render_template('login.html')

@app.route('/signin')
def signup():
    return render_template('signin.html')

@app.route('/chat')
def chat():
    if 'username' in session:
        return render_template('chat.html')
    else:
        return redirect(url_for('login'))

@app.route('/get', methods=['POST'])
def get_bot_response():
    user_input = request.form['msg'].strip().lower()
    return {'reply': responses_dict.get(user_input, "Sorry, I don't understand that yet.")}

@app.route('/do_login', methods=['POST'])
def do_login():
    session['username'] = request.form['username']
    return redirect(url_for('chat'))

@app.route('/do_signup', methods=['POST'])
def do_signup():
    # Optional: Save users (currently just redirects)
    session['username'] = request.form['username']
    return redirect(url_for('chat'))

@app.route('/logout')
def logout():
    session.pop('username', None)
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)
