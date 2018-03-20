.. highlight:: typoscript

.. _configuration:

Configuration
=============

Check out :ref:`search_core:configuration` of *search_core* as everything will be configured through
this extension.

The following additional options are introduced for this extension:

A small example for a full setup::

   plugin.tx_searchcore.settings {
       connections {
           facebook {
               pressAccount {
                   // Credentials
               }
           }
       }

       indexing {
           facebookPosts {
               indexer = Codappix\SearchCoreFacebook\Domain\Index\PostIndexer
               account = pressAccount
               endpoint = /{$config.socialMedia.facebook.pageId}/posts
               parameters {
                   fields = id,created_time,message,link,permalink_url,picture
               }
           }
       }
   }

.. _configuration_connections:

Connections
-----------

Multiple Facebook connections can be setup, to allow indexing of multiple accounts.
Each connection is configured inside of ``plugin.tx_searchcore.settings.connections.facebook``. Use a
unique identifier for each connection, e.g. ``pressAccount``.

The credentials to provide can be obtained from https://packagist.org/packages/facebook/graph-sdk
as this library is used to establish the connection.

.. code-block:: typoscript

   plugin.tx_searchcore.settings.connections {
       facebook {
           <identifier> {
               // Credentials
           }
       }
   }

.. _configuration_indexer:

Indexer
-------

New indexer are introduced, to enable indexing of content from Facebook.
The following indexers are added:

.. toctree::

   Indexer/PostIndexer

.. _configuration_account:

Facebook Account
----------------

As multiple Facebook connections are possible, you have to configure the connection to use for each
index definition. This is done using the ``account`` option, which has to match the ``<identifier>``
of a Facebook connection.

.. code-block:: typoscript

   plugin.tx_searchcore.settings.indexing {
       facebookPosts {
           account = pressAccount
       }
   }

.. _configuration_endpoint:

Endpoint
----------

For each indexing, you have to define the endpoint to use for fetching information. This is done by
providing the option ``endpoint`` with a valid Graph API endpoint:

.. code-block:: typoscript

   plugin.tx_searchcore.settings.indexing {
       facebookPosts {
           parameters {
               endpoint = /{$config.socialMedia.facebook.pageId}/posts
           }
       }
   }

.. _configuration_parameters:

Parameters
----------

All information are fetched from Facebook via REST API. It's possible to define all parameters to
use via TypoScript. Currently only ``fields`` is known to work:

.. code-block:: typoscript

   plugin.tx_searchcore.settings.indexing {
       facebookPosts {
           parameters {
               fields = id,created_time,message,link,permalink_url,picture
           }
       }
   }
