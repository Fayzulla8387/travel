@extends('adminpanel.master')
@section('title', 'Feedbacks')

@section('admin')
    <div class="container mt-4">
        <h2>Feedbacks</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
        @endif


        <!-- Feedback Table -->
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $feedback->client_name }}</td>
                    <td>{{ $feedback->client_email }}</td>
                    <td>{{ $feedback->subject }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($feedback->message, 100) }}</td>
                    <td>
                        @if($feedback->status == 1)
                            <span class="text-success">Approved</span>
                        @else
                            <span class="text-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#feedbackModal" onclick="showFeedback('{{ $feedback->message }}')">View</a>
                        @if($feedback->status == 0)
                            <a href="{{ route('approve', $feedback->id) }}" class="btn btn-success btn-sm">Approve</a>
                        @endif
                        <!-- Delete Button -->
                        <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Feedback Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="feedbackMessage"></p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showFeedback(message) {
                document.getElementById('feedbackMessage').textContent = message;
            }
        </script>



    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Xabarni topamiz
            const successMessage = document.getElementById('successMessage');

            if (successMessage) {
                // 2 soniyadan so'ng xabarni yopish
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 2000); // 2000 ms = 2 soniya
            }
        });
    </script>


@endsection
