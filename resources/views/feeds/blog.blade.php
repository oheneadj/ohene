<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Ohene Adjei Effah — Blog</title>
        <link>{{ route('blog.index') }}</link>
        <description>Practical write-ups on Laravel, WordPress performance, and shipping secure, scalable web applications.</description>
        <language>en</language>
        <atom:link href="{{ route('rss') }}" rel="self" type="application/rss+xml" />
        @foreach ($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>{{ route('blog.show', $post) }}</link>
                <guid isPermaLink="true">{{ route('blog.show', $post) }}</guid>
                <description><![CDATA[{{ $post->excerpt }}]]></description>
                @if ($post->published_at)
                    <pubDate>{{ $post->published_at->toRssString() }}</pubDate>
                @endif
            </item>
        @endforeach
    </channel>
</rss>
