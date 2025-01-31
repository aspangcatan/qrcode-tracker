<!-- resources/views/queue.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header, footer {
            background-color: rgb(240, 0, 0);
            color: white;
            text-align: center;
            padding: 1rem;
        }

        header {
            display: flex;
            align-items: center;
            height: 5%;
        }

        footer {
            display: flex;
            align-items: center;
            text-align: start;
            font-weight: bold;
            font-size: 1.5rem;
            height: 5%;
        }

        .content {
            background-color: #f0f0f0;
            flex: 1;
            display: flex;
            justify-content: space-between;
            height: 100%;
        }

        .video-section, .grid-section {
            width: 50%;
            height: 100%;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .grid-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            height: 100%;
            gap: 0;
        }

        .box {
            border: 1px solid black;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Keep items at the top */
            align-items: center;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px;
        }

        .box .label {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .box .ticket {
            width: 80%;
            color: rgb(24, 41, 102);
            padding: 20px;
            text-align: center;
            font-size: 12.5rem;
            font-weight: bold;
            flex-grow: 1; /* Allow the ticket to grow and take space, keeping the label at the top */
            display: flex;
            justify-content: center;
            align-items: center;

        }
    </style>
</head>
<body>
<header>
    <h1>MEDICAL RECORDS QUEUING SYSTEM</h1>
</header>

<div class="content">
    <div class="video-section">
        <video src="{{ url('videos/9gag.mp4') }}" autoplay muted loop></video>
    </div>
    <div class="grid-section">
        <div class="box">
            <div class="label">WINDOW 1</div>
            <div class="ticket"></div>
        </div>
        <div class="box">
            <div class="label">WINDOW 2</div>
            <div class="ticket"></div>
        </div>
        <div class="box">
            <div class="label">WINDOW 3</div>
            <div class="ticket"></div>
        </div>
    </div>
</div>
<footer>
    <p id="clock"></p>
</footer>

<script src="https://code.responsivevoice.org/responsivevoice.js?key=kiFSuLiB"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const ws = new WebSocket('ws://192.168.4.3:9000');

    ws.onopen = () => {
        console.log('Connected to the WebSocket server');
    };

    // When a message is received
    ws.onmessage = (event) => {
        try {
            // Check if the received data is a Blob
            if (event.data instanceof Blob) {
                // If it's a Blob, convert it to text
                const reader = new FileReader();
                reader.onload = function() {
                    // Once the Blob is converted to text, parse the JSON data
                    const data = JSON.parse(reader.result);
                    console.log('Received message:', data);

                    // Handle the action
                    switch (data.action) {
                        case "NOTIFY":
                            $(".ticket:eq(" + (data.window - 1) + ")").text(data.ticket);
                            responsiveVoice.speak("Now serving, ticket number " + data.ticket + ". Please proceed to window " + data.window);
                            break;
                        default:
                            console.log('Unknown action:', data.action);
                            break;
                    }
                };
                reader.readAsText(event.data); // Read the Blob as text
            } else {
                // If it's not a Blob, parse it directly
                const data = JSON.parse(event.data); // Parse the JSON data from the server
                console.log('Received message:', data);

                switch (data.action) {
                    case "NOTIFY":
                        $(".ticket:eq(" + (data.window - 1) + ")").text(data.ticket);
                        responsiveVoice.speak("Now serving, ticket number " + data.ticket + ". Please proceed to window " + data.window);
                        break;
                    default:
                        console.log('Unknown action:', data.action);
                        break;
                }
            }
        } catch (error) {
            console.error('Error parsing message data:', error); // Log any errors parsing the message
        }
    };

    ws.onclose = () => {
        console.log('Disconnected from the WebSocket server');
    };

    // Handle WebSocket errors
    ws.onerror = (error) => {
        console.error('WebSocket error:', error);
    };

    $(document).ready(() => {
        setInterval(updateClock, 1000);
        loadServing();
    });

    //UTILS
    function updateClock() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true
        };

        // Format the date and time
        const formattedDateTime = now.toLocaleString('en-US', options);

        // Update the clock element with the current date and time
        $("#clock").html(formattedDateTime);
    }

    async function loadServing() {
        const response = await fetch('{{ route('getTicketsTv') }}', {
            method: "GET"
        });

        if (!response.ok) {
            // If the response is not ok, try to get the error message from the response
            const errorText = await response.text(); // Get the response text (error message)
            console.error('Error fetching data:', errorText); // Log the error text
            return;
        }

        try {
            const data = await response.json();
            data.forEach(it => {
                $(".ticket:eq(" + (it.window_no - 1) + ")").text(it.ticket_no);
            });
        } catch (e) {
            console.error('Error parsing JSON:', e);
        }
    }
</script>
</body>
</html>
