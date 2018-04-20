<?$ch = curl_init();
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
$headers = array('Expect:', 'Connection: Keep-Alive', 'Accept-Charset: utf-8,windows-1251;q=0.7,*;q=0.7');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, 'https://lenta.ru/rss/news/'); // Адрес RSS

$rss_str = curl_exec($ch);
if (!$rss_str) exit('rss не получен');
curl_close($ch);

$rss = simplexml_load_string($rss_str, 'SimpleXMLElement', LIBXML_NOCDATA);
$i = 0;
foreach ($rss->channel->item as $item) {
	if ($i == 5) break;?>
	<div>
		<p><a href="<?=$item->link?>"><?=$item->title?></a></p>
		<p><?=$item->description?></p>
	</div>
	<?$i++;
}?>