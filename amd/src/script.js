export const init = (someArray) => {
    document.querySelector('.js-question').innerHTML = someArray[1].question;
    document.querySelector('.js-answer').innerHTML = someArray[1].answer;
    window.console.log(someArray);
};