import pandas as pd

def load_dataset():
    path = r'chatbot_dataset.csv'
    try:
        df = pd.read_csv(path, encoding='windows-1252')
        df.columns = [col.strip().lower().replace(' ', '_') for col in df.columns]
        if 'user_input' in df.columns and 'bot_response' in df.columns:
            df.dropna(subset=['user_input', 'bot_response'], inplace=True)
            df['user_input'] = df['user_input'].astype(str).str.strip().str.lower()
            df['bot_response'] = df['bot_response'].astype(str).str.strip()

            print("✅ Dataset loaded successfully with columns:", list(df.columns))
            return df
        else:
            print("❌ Required columns 'user_input' and 'bot_response' not found.")
            print("📌 Columns available:", list(df.columns))
            return None
    except FileNotFoundError:
        print("❌ File not found. Check the path:", path)
        return None
    except Exception as e:
        print("❌ Error loading dataset:", e)
        return None

def show_head(dataset):
    print("\n🔼 First few rows of the dataset:")
    print(dataset.head())

def show_tail(dataset):
    print("\n🔽 Last few rows of the dataset:")
    print(dataset.tail())

def build_response_dict(dataset):
    return {
        row['user_input'].strip().lower(): row['bot_response']
        for _, row in dataset.iterrows()
    }

def chat_with_bot(responses_dict):
    print("\n💬 Chatbot is ready! Type 'exit' to quit.")
    while True:
        user_input = input("You: ").strip().lower()
        if user_input == 'exit':
            print("Bot: Goodbye! 💫")
            break
        response = responses_dict.get(user_input)
        if response:
            print("Bot:", response)
        else:
            print("Bot: Sorry, I don't understand that yet.")

def menu():
    dataset = None
    responses_dict = None

    while True:
        print("\n📋 Menu:")
        print("1. Load Dataset")
        print("2. Show Dataset Head")
        print("3. Show Dataset Tail")
        print("4. Prepare Chatbot")
        print("5. Chat with Bot")
        print("6. Exit")

        choice = input("Enter your choice: ").strip()

        if choice == '1':
            dataset = load_dataset()
        elif choice == '2':
            if dataset is not None:
                show_head(dataset)
            else:
                print("⚠️ Load the dataset first.")
        elif choice == '3':
            if dataset is not None:
                show_tail(dataset)
            else:
                print("⚠️ Load the dataset first.")
        elif choice == '4':
            if dataset is not None:
                responses_dict = build_response_dict(dataset)
                print("✅ Chatbot prepared successfully.")
            else:
                print("⚠️ Load the dataset first.")
        elif choice == '5':
            if responses_dict is not None:
                chat_with_bot(responses_dict)
            else:
                print("⚠️ Please prepare the chatbot first.")
        elif choice == '6':
            print("👋 Exiting. You're amazing, Ishita!")
            break
        else:
            print("❌ Invalid choice. Please enter 1 to 6.")

if __name__ == "__main__":
    menu()
