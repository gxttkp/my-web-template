const massInput = document.querySelector("#field-mass");
const heightInput = document.querySelector("#field-height");
const bmiResult = document.querySelector("[data-bmi]");
const bmiButton = document.querySelector("[bmi-btn]");
const bmiResultTxt = document.querySelector("[data-bmi-txt]");

bmiButton.addEventListener("click", () => {

    const mass = parseFloat(massInput.value);
    const height = parseFloat(heightInput.value);

    if (isNaN(mass) || isNaN(height)) {
        bmiResult.innerText = "--";
        return;
    }

    const heightMeter = height / 100;

    const bmi = mass / (heightMeter ** 2);

    bmiResult.innerText = bmi.toFixed(2);

    if (bmi < 18.50) {
        bmiResultTxt.innerText = "น้ำหนักน้อย | ผอม";
        bmiResultTxt.className = "screen_show bmi-thin";
        bmiResult.className = "bmi_num bmi-thin";

    } else if (bmi >= 18.50 && bmi <= 22.90) {
        bmiResultTxt.innerText = "ปกติ | สุขภาพดี";
        bmiResultTxt.className = "screen_show bmi-normal";
        bmiResult.className = "bmi_num bmi-normal";

    } else if (bmi >= 23.00 && bmi <= 24.90) {
        bmiResultTxt.innerText = "น้ำหนักเกิน";
        bmiResultTxt.className = "screen_show bmi-overweight";
        bmiResult.className = "bmi_num bmi-overweight";

    } else if (bmi >= 25.00 && bmi <= 29.90) {
        bmiResultTxt.innerText = "อ้วนระดับ 1";
        bmiResultTxt.className = "screen_show bmi-overweight-one";
        bmiResult.className = "bmi_num bmi-overweight-one";

    } else {
        bmiResultTxt.innerText = "อ้วนระดับ 2";
        bmiResultTxt.className = "screen_show bmi-overweight-two";
        bmiResult.className = "bmi_num bmi-overweight-two";
    }
});