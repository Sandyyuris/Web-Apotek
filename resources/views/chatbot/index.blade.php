@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-robot me-2"></i> {{ $title }}
                        </h2>
                        <p class="text-muted">Tanyakan ketersediaan produk, harga, atau informasi kesehatan umum.</p>
                    </div>

                    <div id="chat-window" class="border p-3 mb-4" style="height: 400px; overflow-y: scroll; background-color: #f8f9fa; border-radius: 0.5rem;">
                        <div class="d-flex justify-content-start mb-2">
                            <div class="p-2 ai-message rounded" style="background-color: #e2f9f5; max-width: 80%;">
                                <small class="text-muted">Asisten Apoteker AI</small>
                                <p class="mb-0">Halo! Saya Asisten Apoteker AI dari SHANN APOTEK. Ada yang bisa saya bantu, {{$userName}}?</p>
                            </div>
                        </div>
                    </div>

                    <form id="chat-form">
                        <div class="input-group">
                            <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan Anda..." required>
                            <button type="submit" class="btn main-bg text-white" id="send-button">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const userInput = document.getElementById('user-input');
        const userMessage = userInput.value.trim();
        const chatWindow = document.getElementById('chat-window');
        const sendButton = document.getElementById('send-button');

        if (userMessage === '') return;

        const userDiv = document.createElement('div');
        userDiv.className = 'd-flex justify-content-end mb-2';
        userDiv.innerHTML = `
            <div class="p-2 rounded text-white" style="background-color: #1abc9c; max-width: 80%;">
                <p class="mb-0">${userMessage}</p>
            </div>
        `;
        chatWindow.appendChild(userDiv);
        chatWindow.scrollTop = chatWindow.scrollHeight;

        userInput.value = '';
        sendButton.disabled = true;
        sendButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menunggu...';

        fetch("{{ route('chat.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: userMessage })
        })
        .then(response => response.json())
        .then(data => {
            const aiDiv = document.createElement('div');
            aiDiv.className = 'd-flex justify-content-start mb-2';
            aiDiv.innerHTML = `
                <div class="p-2 ai-message rounded" style="background-color: #e2f9f5; max-width: 80%;">
                    <small class="text-muted">Asisten Apoteker AI</small>
                    <p class="mb-0">${data.reply}</p>
                </div>
            `;
            chatWindow.appendChild(aiDiv);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'd-flex justify-content-start mb-2';
            errorDiv.innerHTML = `
                <div class="p-2 ai-message rounded" style="background-color: #f8d7da; max-width: 80%;">
                    <small class="text-danger">ERROR</small>
                    <p class="mb-0">Terjadi kesalahan koneksi. Coba lagi.</p>
                </div>
            `;
            chatWindow.appendChild(errorDiv);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        })
        .finally(() => {
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
            userInput.focus();
        });
    });
</script>
@endsection
