// response_handler.h

#ifndef RESPONSE_HANDLER_H
#define RESPONSE_HANDLER_H

#include <string>
#include "chatbot.h"

std::string handleUserMessage(Chatbot& chatbot, const std::string& userMessage);

#endif // RESPONSE_HANDLER_H
