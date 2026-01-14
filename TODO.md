# TODO: Fix Chat Response Linking Issue

## Steps to Complete
- [x] Modify the `handle` method in `FrontController.php` to store and retrieve conversation history using Laravel session.
- [x] Append user message to history, send full history to OpenAI API, append AI response, and save back to session.
- [x] Limit conversation history to the last 10 messages to manage token usage.
- [x] Ensure the system prompt is always included at the start of the messages array.
- [x] Test the chat functionality to verify responses are linked and consistent.
