.. highlight:: typoscript

``Codappix\SearchCoreFacebook\Domain\Index\PostIndexer``
========================================================

Allows to index posts of a Facebook timeline.

Endpoint has to be a valid page or user and ``posts``.

Example::

   plugin.tx_searchcore.settings.indexing {
       facebookPosts {
           indexer = Codappix\SearchCoreFacebook\Domain\Index\PostIndexer
           account = pressAccount
           endpoint = /{$config.socialMedia.facebook.pageId}/posts
           parameters {
               fields = id,created_time,message,link,permalink_url,picture
           }
       }
   }
