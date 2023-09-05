let Odometer; // Declare Odometer variable in the global scope
let CountUp; // Declare CountUp variable in the global scope

const importFiles = async () => {
    try {
        // Import file1.js
        const countUpModule = await import("./countUp.js");
        CountUp = countUpModule.default; // Assign the default export to the global variable
        // Access exported values from file1.js using CountUp

        // Import Odometer dynamically
        const odometerModule = await import("./odometer.min.js");
        Odometer = odometerModule.default; // Assign the default export to the global variable
        // Access exported values from odometer.js using Odometer

        // Access the values stored in option1_data
        const inputValue = option1_data.inputValue;
        const acfNumberValue = option1_data.acfNumberValue;

        // You can now use the "inputValue" and "acfNumberValue" in your JavaScript code as needed

        // Your other code goes here...
    } catch (error) {
        console.error('Error while importing files:', error);
    }
};

document.addEventListener('DOMContentLoaded', () => {

    importFiles();
    // Elements
    const numberCodeForm = document.querySelector('[data-number-code-form]');
    const numberCodeInputs = [...numberCodeForm.querySelectorAll('[data-number-code-input]')];
    const fetchButton = document.querySelector('[data-fetch-button]');
    const phoneNumbersContainer = document.getElementById('phoneNumbersContainer');
    const winnerContainer = document.getElementById('winnerContainer');
    const tableBody = phoneNumbersContainer.querySelector('tbody');
    // Variable to store the last four digits
    let lastFourDigits = [];
    const fetchedPhoneNumbers = [];
    const collectedData = [];
    let isFetchStarted = false;
    let fetchCount = 0;
    const maxData = []
    const maxFetchCount = option1_data.acfNumberValue;
    const modifiedItems = [];
    let incrementStep = 0;

    const uploadButton = document.querySelector('[data-upload-button]');

    let h1Element = document.querySelector('.brandTitle');
    let dataTitleBrandValue = h1Element.getAttribute('data-title-brand');

    let h2Element = document.querySelector('.prizeTitle');
    let dataTitlePrizeValue = h2Element.getAttribute('data-title-prize');


    function incrementNot(modifiedItems) {
        incrementStep = 0
        incrementStep = modifiedItems.length / maxFetchCount;
    }

    async function compareWithApiData(lastFourDigits) {

        try {
            // Replace 'API_URL' with the actual URL of the API
            const response = await fetch(`${option1_data.inputValue}`);
            const data = await response.json();
            // Array to store modified items with leading zeros in the id
            maxData.push(data)
            // const randomDigits = generateRandomFourDigits(lastFourDigits[0], data);
            data.forEach((item, index) => {
                const formattedIndex = formatIndexWithLeadingZeros(index);
                item.id = formattedIndex;
                modifiedItems.push(item);
            });

            function formatIndexWithLeadingZeros(index) {
                const numberOfDigits = index.toString().length;

                if (numberOfDigits === 1) {
                    return '000' + index;
                } else if (numberOfDigits === 2) {
                    return '00' + index;
                } else if (numberOfDigits === 3) {
                    return '0' + index;
                }

                return index.toString();
            }
            // Calculate incrementStep after modifiedItems has been populated

            incrementNot(data)

            const foundItem = modifiedItems.find((item, index) => index === parseInt(lastFourDigits.join('')));



            if (foundItem) {
                const phoneNumber = foundItem.phone;
                const userID = foundItem.id;
                const entryId = foundItem.Entry_Id;

                collectedData.push({id: userID, phone: phoneNumber, entry_id: entryId});
                const easingFn = function (t, b, c, d) {
                    var ts = (t /= d) * t;
                    var tc = ts * t;
                    return b + c * (tc * ts + -5 * ts * ts + 10 * tc + -10 * ts + 5 * t);
                }
                // Create a new table row for each phone number entry
                const tableRow = document.createElement('tr');
                tableRow.classList.add('element', 'text-center', 'gap-2', 'row', 'justify-content-center');
                tableBody.appendChild(tableRow);

                // Create a table data cell for the user ID
                const userIDCell = document.createElement('td');
                userIDCell.classList.add('fs-6', 'fw-smaller', 'element', 'user-id', 'badge', 'bg-warning', 'text-dark', 'w-auto', 'align-bottom', 'pb-1', 'pt-2', 'fw-bolder', 'intro-up');
                userIDCell.textContent = `Winner ID: ${userID}`;
                tableRow.appendChild(userIDCell);

                // Create a table data cell for the phone number
                const phoneNumberCell = document.createElement('td');
                phoneNumberCell.id = `phoneNumber-${fetchedPhoneNumbers.length + 1}`;
                phoneNumberCell.classList.add('counterUp', 'border', 'border-1', 'border-white', 'pb-3', 'pt-4', 'fs-3', 'element', 'text-white', 'rounded-2', 'intro-down', 'bg-dark', 'bg-opacity-50');



                tableRow.appendChild(phoneNumberCell);
                fetchedPhoneNumbers.push(phoneNumber);

                // Check if the process has reached the limit of 5 times
                if (fetchedPhoneNumbers.length >= option1_data.acfNumberValue) {
                    uploadButton.classList.add('fade-in');
                    fetchButton.disabled = true;
                }

                // Animate the phone number with CountUp.js
                const options = {
                    formattingFn: (n) => {
                        return formatNumber(n);
                    },
                    easingFn,
                    startVal: 0,
                    separator: '',
                    prefix: '۰',
                    decimal: '',
                    numerals: ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
                };

                function formatNumber(num) {
                    const numAsString = num.toString();
                    if (numAsString.length >= 6) {
                        const firstThreeDigits = numAsString.substring(0, 3);
                        return '0' + firstThreeDigits + '***' + numAsString.substring(6);
                    }
                    return numAsString;
                }

                const phoneNumberCountUp = new CountUp(`phoneNumber-${fetchedPhoneNumbers.length}`, phoneNumber, options);
                if (!phoneNumberCountUp.error) {
                    phoneNumberCountUp.start();
                } else {
                    console.error(phoneNumberCountUp.error);
                }

                console.log("Success! Matching item found:", foundItem);
            } else {
                console.log("Not found. No matching item with last four digits:", lastFourDigits.join(''));
            }
        } catch (error) {
            console.error("Error fetching data from API:", error);
        }
    }

// Function to fetch JWT token
    async function getJWTToken() {
        const apiUrl = option1_data.site_url + '/wp-json/jwt-auth/v1/token';
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                // Include user credentials (username and password) for generating the token
                body: JSON.stringify({
                    username: option1_data.username, // Replace with the WordPress username
                    password: option1_data.password, // Replace with the WordPress password
                }),
            });

            if (response.ok) {
                const data = await response.json();
                return data.token;
            } else {
                throw new Error('Failed to get JWT token.');
            }
        } catch (error) {
            console.error('Error getting JWT token:', error);
            throw error;
        }
    }
    async function sendPostRequest(jwtToken) {
        const requestData = collectedData.map(item => ({
            entry_id: item.entry_id,
            phone_number: item.phone,
            campaign_prize: dataTitlePrizeValue, // Replace with your prize data
            brand: dataTitleBrandValue, // Replace with your brand data
        }));
        try {
            const apiUrl = option1_data.site_url + '/wp-json/lucky-draw/v1/add-entry';
            const response = await fetch(apiUrl, {
                method: 'POST',
                body: JSON.stringify(requestData),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwtToken}`, // Include JWT token in the Authorization header
                },
            });
            if (response.ok) {
                const responseText = await response.json();
                const deleteData = collectedData.map(item => ({
                    entry_id: item.entry_id,
                }));
                try {
                    console.log(deleteData)
                    const apiUrl = option1_data.inputValue;
                    const response = await fetch(apiUrl, {
                        method: 'DELETE',
                        body: JSON.stringify(deleteData),
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });
                    if (response.ok) {
                        const responseText = await response.json();
                        winnerContainer.innerHTML = '<div class="badge bg-warning text-center fs-4">Winner List Successfully Submitted</div>';
                        console.log(responseText)
                    } else {
                        console.error('POST request failed:', response.statusText);
                        winnerContainer.innerHTML = '<div>Winner List Failed to Submit</div>';
                    }
                } catch (error) {
                    console.error('Error sending POST request:', error);
                }

                console.log(responseText)
            } else {
                console.error('POST request failed:', response.statusText);
            }
        } catch (error) {
            console.error('Error sending POST request:', error);
        }
    }
    // Main function to handle the button click
    uploadButton.addEventListener('click', async () => {
        try {
            const jwtToken = await getJWTToken(); // Get the JWT token

            if (jwtToken) {
                await sendPostRequest(jwtToken); // Send the POST request with the JWT token
            } else {
                console.error('JWT token not available.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Function to check if all inputs have been filled
    function areAllInputsFilled() {
        return numberCodeInputs.every(input => input.value.length === 1);
    }

    // Event callbacks
    const handleInput = ({target}) => {
        if (!target.value.length) {
            return target.value = null;
        }

        const inputLength = target.value.length;
        let currentIndex = Number(target.dataset.numberCodeInput);

        if (inputLength > 1) {
            const inputValues = target.value.split('');
            inputValues.forEach((value, valueIndex) => {
                const nextValueIndex = currentIndex + valueIndex;

                if (nextValueIndex >= numberCodeInputs.length) {
                    return;
                }

                numberCodeInputs[nextValueIndex].value = value;
            });

            currentIndex += inputValues.length - 2;
        }

        const nextIndex = currentIndex + 1;

        if (nextIndex < numberCodeInputs.length) {
            numberCodeInputs[nextIndex].focus();
        }

        // Check if all inputs have been filled
        if (areAllInputsFilled()) {
            // Extract the last four digits and store them in the variable
            lastFourDigits = numberCodeInputs.slice(-4).map(input => parseInt(input.value));
        }
    };
    function fetchPhoneNumber() {
        if (fetchCount >= maxFetchCount) {
            fetchButton.disabled = true;
            return;
        }
        if (fetchCount === 0) {
            // For the first fetch, use the first number as entered by the user
            if (lastFourDigits.length === 4) {
                compareWithApiData(lastFourDigits);
            } else {
                console.log("Please fill all four digits before fetching the API.");
            }
        } else {
            // For the rest of the fetches, generate numbers based on the new algorithm
            let enteredNumber = Number(lastFourDigits.join(''));

            const generatedNumber = enteredNumber + (Math.floor(incrementStep));
            const randomDigits = generatedNumber.toString().padStart(4, '0').split('').map(Number);


            lastFourDigits = randomDigits;
            //
            for (let j = 0; j < 4; j++) {
                numberCodeInputs[j].value = randomDigits[j];
            }
            enteredNumber = generatedNumber; // Update enteredNumber for the next iteration
            incrementStep = 0
            if (generatedNumber >= maxData[0].length) {

                compareWithApiData(Math.abs(generatedNumber - maxData[0].length).toString().padStart(4, '0').split('').map(Number));
            } else if (generatedNumber <= maxData[0].length) {
                console.log('smaller' + generatedNumber)
                compareWithApiData(lastFourDigits);
            }
        }

        fetchCount++;
    }


    fetchButton.addEventListener('click', () => {
        if (!isFetchStarted) {
            isFetchStarted = true;
            fetchPhoneNumber(modifiedItems); // Initial fetch
            setInterval(() => fetchPhoneNumber(modifiedItems), 2000); // Repeat every 4 seconds
        }
    });

    // Event listeners
    numberCodeForm.addEventListener('input', handleInput);
    const handleKeyDown = e => {
        const {code, target} = e;

        const currentIndex = Number(target.dataset.numberCodeInput);
        const previousIndex = currentIndex - 1;
        const nextIndex = currentIndex + 1;

        const hasPreviousIndex = previousIndex >= 0;
        const hasNextIndex = nextIndex <= numberCodeInputs.length - 1

        switch (code) {
            case 'ArrowLeft':
            case 'ArrowUp':
                if (hasPreviousIndex) {
                    numberCodeInputs[previousIndex].focus();
                }
                e.preventDefault();
                break;

            case 'ArrowRight':
            case 'ArrowDown':
                if (hasNextIndex) {
                    numberCodeInputs[nextIndex].focus();
                }
                e.preventDefault();
                break;
            case 'Backspace':
                if (!e.target.value.length && hasPreviousIndex) {
                    numberCodeInputs[previousIndex].value = null;
                    numberCodeInputs[previousIndex].focus();
                }
                break;
            default:
                break;
        }
    }
    numberCodeForm.addEventListener('keydown', handleKeyDown);
});
