# trivium
Serves randomized trivia questions about the University of Michigan as JSON

View on the web at [vitez.me/trivium](http://vitez.me/trivium)

The correct answer is always passed in the `answer` field.

## How to Access

You may obtain an API key by contacting me however you choose. Without a key, vitez.me/trivium will always display its initial message.

Once you obtain a key, remember to pass it in the url (like this: http://vitez.me/trivium/?key=API_KEY )

## Options

All options are passed in urls as parameters.

Note: Difficulty and type selectors are not yet implemented

- Limit: Number of results to return. Defaults to 1. If limit is higher than the total number of questions in the database, returns the whole database. Example: http://vitez.me/trivium/?key=API_KEY&limit=3

- Difficulty: How hard questions are to answer. Possible values are `easy`, `medium`, and `hard`. Defaults to `easy+medium+hard`. Can provide subsets of questions based on their difficulty as assessed by the writer. Can be combined using the `+` separator. Example:  http://vitez.me/trivium/?key=API_KEY&difficulty=easy+medium

- Type: Kinds of questions to return. Possible values are `number`, `multchoice`, and `image`. Defaults to `number+multchoice+image`. Like difficulty, can be combined using the `+` separator. Example:  http://vitez.me/trivium/?key=API_KEY&type=image

## Question Types

- Multiple choice: Denoted by `multchoice`. A question with four textual answers, one of which is correct.

- Number: Denoted by `number`. A question with a single numerical answer.

- Image: Denoted by `image`. Just like multiple choice, but also returns a url of an image that is relevant to the question.
