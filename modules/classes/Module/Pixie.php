<?php
namespace Module;

class Pixie
{
    private static string $ext = '.pixie.php';
    private static string $templatePath = __DIR__ . '/../../../app/Views';

    public static function render($template, $data = []): string
    {
        $templateFile = self::$templatePath . '/' . str_replace('.', '/', $template);

        if (file_exists($templateFile . self::$ext)) {
            ob_start();
            extract($data);
            $templateContent = file_get_contents($templateFile . self::$ext);
            $processedContent = self::processPixieCodes($templateContent, $data);

            eval(' ?>' . $processedContent . '<?php ');

            $content = ob_get_clean();
            return $content;
        } else if (file_exists($templateFile . '.php')) {
            ob_start();
            extract($data);
            $templateContent = file_get_contents($templateFile . '.php');

            eval(' ?>' . $templateContent . '<?php ');

            $content = ob_get_clean();
            return $content;
        } else {
            throw new \Exception("Template file not found: {$templateFile}");
        }
    }


    private static function processPixieCodes($content, $data): string
    {
        $content = self::compileComments($content);
        $content = self::get_link_for($content);
        $content = self::do_redirect($content);
        $content = self::get_favicon($content);
        $content = self::get_css_link($content);
        $content = self::get_js_src($content);
        $content = self::get_img_src($content);
        $content = self::compileComments($content);
        $content = self::compilePHP($content);
        $content = self::compileEchos($content, $data);
        $content = self::compileFuncs($content, $data);
        $content = self::compileIfElse($content);
        $content = self::compileConditions($content);
        $content = self::compileLoops($content);

        return $content;
    }

    private static function get_link_for($content): string
    {
        $patt = '/link_for\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            return (ROOT_PATH !== '/') ? ROOT_PATH . $m[1] : $m[1];
        }, $content);
    }
    private static function do_redirect($content): string
    {
        $patt = '/\@redirect\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            return (ROOT_PATH !== '/') ? '<?php (new Header())->Location("' . ROOT_PATH . $m[1] . '") ?>' : '<?php (new Header())->Location("' . $m[1] . '") ?>';
        }, $content);
    }

    private static function get_favicon($content): string
    {
        $patt = '/\@favicon\@/i';
        return preg_replace_callback($patt, function ($m) {
            $fav_path = __DIR__ . "/../../../public/favicon.ico";
            if (file_exists($fav_path)) {
                return ROOT_PATH . "/public/favicon.ico";
            }
        }, $content);
    }

    private static function get_css_link($content): string
    {
        $patt = '/\@css_link\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            $file_name = $m[1];
            $css_path = __DIR__ . "/../../../public/assets/css/{$file_name}.css";
            if (file_exists($css_path)) {
                return ROOT_PATH . "/public/assets/css/{$file_name}.css?r=" . rand();
            }
        }, $content);
    }
    private static function get_js_src($content): string
    {
        $patt = '/\@js_src\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            $file_name = $m[1];
            $js_path = __DIR__ . "/../../../public/assets/js/{$file_name}.js";
            if (file_exists($js_path)) {
                return ROOT_PATH . "/public/assets/js/{$file_name}.js";
            }
        }, $content);
    }
    private static function get_font_link($content): string
    {
        $patt = '/\@font_link\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            $file_name = $m[1];
            $font_path = __DIR__ . "/../../../public/assets/fonts/{$file_name}";
            if (file_exists($font_path)) {
                return ROOT_PATH . "/public/assets/fonts/{$file_name}";
            }
        }, $content);
    }
    private static function get_img_src($content): string
    {
        $patt = '/\@img_src\(\s*(.*?)\s*\)/i';
        return preg_replace_callback($patt, function ($m) {
            $file_name = $m[1];
            $img_path = __DIR__ . "/../../../public/assets/images/{$file_name}";
            if (file_exists($img_path)) {
                return ROOT_PATH . "/public/assets/images/{$file_name}";
            }
        }, $content);
    }

    private static function compileComments($content): string
    {
        $patt = '~{--\s*.*?\s*--}~is';
        return preg_replace($patt, '', $content);
    }

    private static function compilePHP($content): string
    {
        $content = preg_replace_callback('/@php([^}]+)@endphp/', function ($matches) {
            $code = trim($matches[1]);
            return "<?php $code ?>";
        }, $content);
        return $content;
    }
    private static function compileEchos($content, $data): string
    {
        //
        $patt1 = '/\@{{\s*(.*?)\s*}}/i';
        $patt2 = '/\@{!{\s*(.*?)\s*}}/i';
        $patt3 = '/\@{\s*data_info\s*\(\s*(.*?)\s*\)\s*}/i';
        $patt4 = '|\@\[\[\s*(.*?)\s*\]\]|U';
        $patt5 = '/\@{\?{\s*(.*?)\s*}}/i';
        $patt6 = '/\@{\?!{\s*(.*?)\s*}}/i';

        $content = preg_replace_callback(
            $patt1,
            function ($m) use ($data) {
                return "<?php echo htmlspecialchars(" . self::compileFuncs($m[1], $data) . "); ?>";
            },
            $content
        ); // Html escape Echo

        $content = preg_replace_callback(
            $patt2,
            function ($m) use ($data) {
                return "<?php echo " . self::compileFuncs($m[1], $data) . "; ?>";
            },
            $content
        ); // Html no-escape Echo

        $content = preg_replace_callback(
            $patt3,
            function ($m) use ($data) {
                return "<?php var_dump(" . self::compileFuncs($m[1], $data) . "); ?>";
            },
            $content
        ); // var_dump

        $content = preg_replace_callback(
            $patt4,
            function ($m) use ($data) {
                return "<?php print_r(" . self::compileFuncs($m[1], $data) . "); ?>";
            },
            $content
        ); // print_r

        $content = preg_replace_callback(
            $patt5,
            function ($m) use ($data) {
                return "<?php echo (isset(" . $m[1] . ") ? htmlspecialchars(" . self::compileFuncs($m[1], $data) . ") : ''); ?>";
            },
            $content
        ); // Html escape Echo if isset

        $content = preg_replace_callback(
            $patt6,
            function ($m) use ($data) {
                return "<?php echo (isset(" . $m[1] . ") ? " . self::compileFuncs($m[1], $data) . " : ''); ?>";
            },
            $content
        ); // Html no-escape Echo if isset

        return $content;
    }

    private static function compileIfElse($content): string
    {
        $content = preg_replace('/@if\((.*?)\)/', '<?php if ($1) { ?>', $content);
        $content = preg_replace('/@endif/', '<?php } ?>', $content);
        $content = preg_replace('/@elseif\((.*?)\)/', '<?php } elseif ($1) { ?>', $content);
        $content = preg_replace('/@else/', '<?php } else { ?>', $content);
        $content = preg_replace('/@endif/', '<?php } ?>', $content);
        return $content;
    }

    private static function compileConditions($content): string
    {
        $content = preg_replace('/@isset\((.*?)\)/', '<?php if (isset($1)) { ?>', $content);
        $content = preg_replace('/@endisset/', '<?php } ?>', $content);

        $content = preg_replace('/@empty\((.*?)\)/', '<?php if (empty($1)) { ?>', $content);
        $content = preg_replace('/@endempty/', '<?php } ?>', $content);

        return $content;
    }

    private static function compileLoops($content): string
    {
        // foreach loop
        $content = preg_replace('/@foreach\((.*?) as (.*?)\)/i', '<?php foreach ($1 as $2) { ?>', $content);
        $content = preg_replace('/@endforeach/i', '<?php } ?>', $content);
        // for loop
        $content = preg_replace('/@for\((.*?);(.*?);(.*?)\)/i', '<?php for ($1; $2; $3) { ?>', $content);
        $content = preg_replace('/@endfor/i', '<?php } ?>', $content);
        // while loop
        $content = preg_replace('/@while\((.*?)\)/', '<?php while ($1) { ?>', $content);
        $content = preg_replace('/@endwhile/i', '<?php } ?>', $content);

        return $content;
    }

    private static function compileFuncs($content, $data)
    {
        $spt = '\@php[^}]+@endphp(*SKIP)(*FAIL)';
        $patt1 = '/' . $spt . '|\@json\(\s*(.*?)\s*\)/i';
        $patt2 = '/' . $spt . '|\@toArray\(\s*(.*?)\s*\)/i';
        $patt3 = '/' . $spt . '|\@include\(\s*(.*?)\s*\)/i';

        $content = preg_replace_callback(
            $patt1,
            function ($m) {
                return '<?php echo json_encode( ' . $m[1] . ' ); ?>';
            },
            $content
        ); // json

        $content = preg_replace_callback(
            $patt2,
            function ($m) {
                return '<?php json_decode( ' . $m[1] . ' ); ?>';
            },
            $content
        ); // toArray

        $content = preg_replace_callback(
            $patt3,
            function ($m) use ($data) {
                $sub_template = trim($m[1]);
                $compiled_ifile = self::render($sub_template, $data);
                return $compiled_ifile;
            },
            $content
        ); // include_file

        return $content;
    }
}