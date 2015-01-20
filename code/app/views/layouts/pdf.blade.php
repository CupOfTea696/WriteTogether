<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Write | Together</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <style>
        body{
            line-height: 1.25;
        }
        
        p{
            page-break-inside: avoid;
        }
        
        .cover{
            h1{
                display: block;
                width: 100%;
                text-align: center;
            }
        }
        
        .story{
            page-break-after: always;
        }
        
        .contributors ul{
            margin-left: 3em;
            border-left: .3em solid #eee;
            padding-left: 1em;
            list-style: none;
        }
    </style>
</head>
<body>
    <script type="text/php">
        if(isset($pdf)){
            $font = Font_Metrics::get_font("helvetica", "light");
            $size = 9;
            $y = $pdf->get_height() - 32;
            $x = $pdf->get_width() - 32 - Font_Metrics::get_text_width('1/1', $font, $size);
            $pdf->page_text($x, $y, '{PAGE_NUM}', $font, $size);
        }
    </script>
    @yield('pdf')
</body>
</html>
