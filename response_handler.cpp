// response_handler.cpp
#include "chatbot.h"
#include <string>
#include <algorithm>
// Optional: You can preprocess user input here (e.g., lowercase, trim)
std::string preprocessInput(const std::string& input) {
    std::string cleaned = input;
    std::transform(cleaned.begin(), cleaned.end(), cleaned.begin(), ::tolower);
    return cleaned;
}
// Main function to handle chatbot response logic
std::string handleUserMessage(Chatbot& chatbot, const std::string& userMessage) {
    std::string processedInput = preprocessInput(userMessage);
    return chatbot.getResponse(processedInput);
}
