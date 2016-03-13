<?php

class PageTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testDisplaysHomePage()
	{		
        $crawler = $this->client->request('GET', '/');	
	}

}
