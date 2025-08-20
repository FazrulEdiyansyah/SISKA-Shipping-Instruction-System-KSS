<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Shipping Instruction</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        .preview-container {
            display: flex;
            height: 100vh;
            background: #f5f5f5;
        }
        .pdf-viewer {
            flex: 1;
            background: #525659;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .pdf-frame {
            width: 90%;
            height: 95%;
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .sidebar {
            width: 280px;
            background: #f8f9fa;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            gap: 12px;
        }
        .action-btn {
            width: 100%;
            padding: 12px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-cetak {
            background: #3b82f6;
            color: white;
        }
        .btn-cetak:hover {
            background: #2563eb;
        }
        .btn-download {
            background: #10b981;
            color: white;
        }
        .btn-download:hover {
            background: #059669;
        }
        .btn-tutup {
            background: #ef4444;
            color: white;
        }
        .btn-tutup:hover {
            background: #dc2626;
        }
        .sidebar-icon {
            color: #2563eb;
            font-size: 32px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <!-- PDF Viewer Section -->
        <div class="pdf-viewer">
            <iframe src="{{ url('/shipping-instruction/preview-pdf') }}" 
                    class="pdf-frame" 
                    frameborder="0">
            </iframe>
        </div>

        
        <!-- Sidebar Actions -->
        <div class="sidebar">
            <i class="fas fa-file-pdf sidebar-icon"></i>
            
            <form method="POST" action="/shipping-instruction/save" class="w-full flex flex-col gap-3">
                @csrf
                @foreach(session('si_preview_data', []) as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                
                <a href="/shipping-instruction-preview/download" class="action-btn btn-download">
                    <i class="fas fa-file-pdf"></i>
                    Download & Save PDF
                </a>
                
                <a href="/shipping-instruction?from_preview=1" class="action-btn btn-tutup">
                    <i class="fas fa-times"></i>
                    Close
                </a>
            </form>
        </div>
    </div>

    <script>
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            if (e.key === 'Escape') {
                window.location.href = '/shipping-instruction';
            }
        });
    </script>
</body>
</html>