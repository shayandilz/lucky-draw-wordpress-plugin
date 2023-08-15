/**
 * Prize data will space out evenly on the deal wheel based on the amount of items available.
 * @param text [string] name of the prize
 * @param color [string] background color of the prize
 * @param reaction ['resting' | 'dancing' | 'laughing' | 'shocked'] Sets the reaper's animated reaction
 */
document.addEventListener("DOMContentLoaded", function () {
    const wheel = document.querySelector(".deal-wheel");
    const spinner = wheel.querySelector(".spinner");
    const trigger = wheel.querySelector(".btn-spin");
    const ticker = wheel.querySelector(".ticker");
    const prizeSlice = 360 / option2RepeaterData.length;
    const prizeOffset = Math.floor(180 / option2RepeaterData.length);
    const spinClass = "is-spinning";
    const selectedClass = "selected";
    const spinnerStyles = window.getComputedStyle(spinner);
    let tickerAnim;
    let rotation = 0;
    let currentSlice = 0;
    let prizeNodes;
    const createPrizeNodes = () => {
        option2RepeaterData.forEach(({text, color, image_url}, i) => {
            const rotation = prizeSlice * i * -1 - prizeOffset;

            spinner.insertAdjacentHTML(
                "beforeend",
                `<li class="prize" data-reaction=${image_url} style="--rotate: ${rotation}deg">
        <img width="80px" src="${image_url}" alt="">
        <span class="text">${text}</span>
      </li>`
            );
        });
    };
    const createConicGradient = () => {
        spinner.setAttribute(
            "style",
            `background: conic-gradient(
      from -90deg,
      ${option2RepeaterData
                .map(
                    ({color}, i) =>
                        `${color} 0 ${(100 / option2RepeaterData.length) * (option2RepeaterData.length - i)}%`
                )
                .reverse()}
    );`
        );
    };
    const setupWheel = () => {
        createConicGradient();
        createPrizeNodes();
        prizeNodes = wheel.querySelectorAll(".prize");
    };
    const spinertia = (min, max) => {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    const runTickerAnimation = () => {
        const values = spinnerStyles.transform.split("(")[1].split(")")[0].split(",");
        const a = values[0];
        const b = values[1];
        let rad = Math.atan2(b, a);

        if (rad < 0) rad += 2 * Math.PI;

        const angle = Math.round(rad * (180 / Math.PI));
        const slice = Math.floor(angle / prizeSlice);

        if (currentSlice !== slice) {
            ticker.style.animation = "none";
            setTimeout(() => (ticker.style.animation = null), 10);
            currentSlice = slice;
        }

        tickerAnim = requestAnimationFrame(runTickerAnimation);
    };
    const selectPrize = () => {
        const selected = Math.floor(rotation / prizeSlice);
        console.log(prizeNodes[selected])
        prizeNodes[selected].classList.add(selectedClass);
    };
    trigger.addEventListener("click", () => {
        trigger.disabled = true;
        rotation = Math.floor(Math.random() * 360 + spinertia(2000, 5000));
        prizeNodes.forEach((prize) => prize.classList.remove(selectedClass));
        wheel.classList.add(spinClass);
        spinner.style.setProperty("--rotate", rotation);
        ticker.style.animation = "none";
        runTickerAnimation();
    });
    spinner.addEventListener("transitionend", () => {
        cancelAnimationFrame(tickerAnim);
        trigger.disabled = false;
        trigger.focus();
        rotation %= 360;
        selectPrize();
        wheel.classList.remove(spinClass);
        spinner.style.setProperty("--rotate", rotation);
    });
    setupWheel();
});
