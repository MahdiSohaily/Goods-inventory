<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        $rates = DB::table('rates')
            ->select('amount', 'status')
            ->orderBy('amount', 'asc')
            ->get();
        return Inertia::render('Dashboard', ['rates' => $rates]);
    }

    public function search(Request $request)
    {
        $pattern = $request->input('pattern');
        $result = DB::table('nisha')->where('partnumber', 'like', "$pattern%")->get();
        return response()->json([$result]);
    }

    public function mobis(string $mobis = null)
    {
        $user = DB::table('nisha')->where('partnumber', '=', "$mobis")->get();
        $context = stream_context_create(array("http" => array("header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36")));

        if ($this->get_http_response_code("https://partsmotors.com/products/$mobis") != "200") {

            DB::update(
                "update nisha set mobis = '-' where partnumber = '?'",
                [$mobis]
            );
            return;
        } else {
            require_once 'simple_html_dom.php';
            $html = file_get_contents("https://partsmotors.com/products/$mobis", false, $context);
            $html = str_get_html($html);
            foreach ($html->find('meta[property=og:price:amount]') as $element)
                $price = $element->content;
            $partNumber = $mobis;
            $price = str_replace(",", "", $price);
            $avgPrice = round($price * 100 / 243.5 * 1.1);
            $sql = "UPDATE nisha SET mobis='$price' WHERE partnumber='$mobis'";
            $result = mysqli_query($con, $sql);
            $template .= "<tr class='mobis'>
                    <td class='part text-white bold'> $partNumber-M</td>
                    <td>" . round($avgPrice / 1.1) . "</td>
                    <td class='bold'>" . round($avgPrice) . "</td>
                    <td>" . round($avgPrice * 1.1) . "</td>";
            $template .= $this->getPriceMobisPage($avgPrice);
            $template .= "<td class='action'>
                    <a target='_blank' href='https://www.google.com/search?tbm=isch&q=$partNumber'>
                    <img class='social' src='/public/img/google.png' alt='google'>
                    </a>
                    <a target='_blank' href='https://api.telegram.org/bot1681398960:AAGykdRX-71G0PcK2X_yf3uVQOFWKVNMxoc/sendMessage?chat_id=-522041592&text=$partNumber Mobis'>
                    <img class='social' src='/public/img/tel.png' alt='part'>
                    </a>
                </td></tr>";
        }
    }

    function get_http_response_code($url)
    {
        ini_set('user_agent', 'Mozilla/5.0');
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
}
