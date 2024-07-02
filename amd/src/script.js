export const init = (someArray) => {
    const arrKeys = Object.keys(someArray);
    for (let i = 0; i < arrKeys.length; i++) {
        window.console.log(someArray[arrKeys[i]].question);
    }
    window.console.log(someArray);

    let currKeyElem = 0;
    let isAnswer = false;
    document.querySelector('.js-content').innerHTML = someArray[arrKeys[currKeyElem]].question;
    document.querySelector('.js-card').addEventListener('click', () => {
        isAnswer = !isAnswer;
        checkAnswer(currKeyElem);
    });

    document.querySelector('.js-prev').addEventListener('click', () => {
        if (--currKeyElem < 0) {
            currKeyElem = arrKeys.length - 1;
        }
        isAnswer = false;
        checkAnswer(currKeyElem);
    });

    document.querySelector('.js-next').addEventListener('click', () => {
        if (++currKeyElem > arrKeys.length - 1) {
            currKeyElem = 0;
        }
        isAnswer = false;
        checkAnswer(currKeyElem);
    });

    /**
     * Swaps the question and answer on the flashcard
     *
     * @param {object} arrId The key for the object
     */
    function checkAnswer(arrId) {
        if (isAnswer) {
            document.querySelector('.js-content').innerHTML = someArray[arrKeys[arrId]].answer;
        } else {
            document.querySelector('.js-content').innerHTML = someArray[arrKeys[arrId]].question;
        }
    }
};