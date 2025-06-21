 # import pandas as pd
# from sklearn.feature_extraction.text import TfidfVectorizer
# from sklearn.linear_model import LogisticRegression
# from sklearn.pipeline import make_pipeline
# from sklearn.model_selection import train_test_split

# def load_dataset():
#     path = r'chatbot_dataset.csv'
#     try:
#         df = pd.read_csv(path, encoding='windows-1252') 
#         df.columns = [col.strip().lower().replace(' ', '_') for col in df.columns]
#         if 'user_input' in df.columns and 'bot_response' in df.columns:
#             print("✅ Dataset loaded successfully with columns:", list(df.columns))
#             return df
#         else:
#             print("❌ Required columns 'user_input' and 'bot_response' not found.")
#             print("📌 Columns available in dataset:", list(df.columns))
#             return None
#     except FileNotFoundError:
#         print("❌ File not found. Please check the path:", path)
#         return None
#     except Exception as e:
#         print("❌ Error loading dataset:", e)
#         return None

# def show_head(dataset):
#     print("\n🔼 First few rows of the dataset:")
#     print(dataset.head())

# def show_tail(dataset):
#     print("\n🔽 Last few rows of the dataset:")
#     print(dataset.tail())

# def train_chatbot_model(dataset):
#     try:
#         X = dataset['user_input'].astype(str).str.lower()
#         y = dataset['bot_response'].astype(str)

#         X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

#         model = make_pipeline(TfidfVectorizer(), LogisticRegression(max_iter=1000))
#         model.fit(X_train, y_train)

#         print(f"✅ Model trained successfully on {len(X_train)} examples.")
#         return model
#     except KeyError as ke:
#         print(f"❌ Missing column: {ke}")
#     except Exception as e:
#         print("❌ Error during model training:", e)
#     return None

# def chat_with_bot(responses_dict):
#     print("\n💬 Chatbot is ready! Type 'exit' to quit.")
#     while True:
#         user_input = input("You: ").strip().lower()
#         if user_input == 'exit':
#             print("Bot: Goodbye! 💫")
#             break
#         response = responses_dict.get(user_input)
#         if response:
#             print("Bot:", response)
#         else:
#             print("Bot: Sorry, I don't understand that yet.")

# def menu():
#     dataset = None
#     model = None

#     while True:
#         print("\n📋 Menu:")
#         print("1. Load Dataset")
#         print("2. Show Dataset Head")
#         print("3. Show Dataset Tail")
#         print("4. Train Chatbot")
#         print("5. Chat with Bot")
#         print("6. Exit")

#         choice = input("Enter your choice: ").strip()

#         if choice == '1':
#             dataset = load_dataset()
#         elif choice == '2':
#             if dataset is not None:
#                 show_head(dataset)
#             else:
#                 print("⚠️ Load the dataset first.")
#         elif choice == '3':
#             if dataset is not None:
#                 show_tail(dataset)
#             else:
#                 print("⚠️ Load the dataset first.")
#         elif choice == '4':
#             if dataset is not None:
#                 model = train_chatbot_model(dataset)
#             else:
#                 print("⚠️ Load the dataset first.")
#         elif choice == '5':
#             if model is not None:
#                 chat_with_bot(model)
#             else:
#                 print("⚠️ Train the chatbot first.")
#         elif choice == '6':
#             print("👋 Exiting. You’re awesome, Ishita!")
#             break
#         else:
#             print("❌ Invalid choice. Please enter 1 to 6.")

# if __name__ == "__main__":
#     menu()


import pandas as pd

def load_dataset():
    path = r'chatbot_dataset.csv'
    try:
        df = pd.read_csv(path, encoding='windows-1252')
        df.columns = [col.strip().lower().replace(' ', '_') for col in df.columns]
        if 'user_input' in df.columns and 'bot_response' in df.columns:
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
            print("👋 Exiting. You're amazing!")
            break
        else:
            print("❌ Invalid choice. Please enter 1 to 6.")

if __name__ == "__main__":
    menu()