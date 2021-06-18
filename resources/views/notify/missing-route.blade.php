<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Missing route</title>
</head>
<body>
    <h1>It works!</h1>

    <div class="detail">
        <div class="group">
            <div class="title">ID:</div>
            <div class="value">{{ $result->id }}</div>
        </div>
        <div class="group">
            <div class="title">Status:</div>
            <div class="value">{{ $result->status }}</div>
        </div>
        <div class="group">
            <div class="title">Order:</div>
            <div class="value">{{ $result->order }}</div>
        </div>
        <div class="group">
            <div class="title">Email:</div>
            <div class="value">{{ $result->email }}</div>
        </div>
        <div class="group">
            <div class="title">Subject:</div>
            <div class="value">{{ $result->subject }}</div>
        </div>
        <div class="group">
            <div class="title">Amount:</div>
            <div class="value">{{ $result->amount }}</div>
        </div>
    </div>

    {{-- @foreach ($result as $key => $item)
        <div>{{ $key }}</div>
    @endforeach --}}

    <pre>{{ $result }}</pre>

    <p>Your order was finished! but if you want to show a nice view, you need to create a route with name "{{ $routeName }}", to showing final result to your user</p>
</body>
</html>

<style>
    @import('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    :root {
        --color-one:  #000036;
        --color-two:  #00E48C;
        --color-three:  #fff;
    }

    html {
        font-family: 'Poppins', sans-serif;
        background: var(--color-one);
        color: var(--color-three);
        text-align: center;
    }

    h1 {
        color: var(--color-two);
    }

    .detail {
        background: var(--color-three);
        color: var(--color-one);
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        border-radius: 5px;
        padding: 5px;
    }

    .group {
        margin: 5px;
    }

    .title {
        font-weight: 600;
    }

    pre {
        margin: 20px;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    p {
        background: var(--color-two);
        padding: 10px;
    }
</style>
