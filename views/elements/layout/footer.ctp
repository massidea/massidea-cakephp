<div id="footer-menu" class="nolist">
	<ul>
		<li>&copy; 2009 <a href="http://massidea.org">Massidea.org</a></li>
	</ul>
</div>
<?php /* ?>
		<li>
			<a href="http://www.massidea.org/blog/?page_id=40">
			<?php echo __('index-about'); ?></a>
		</li>
		<li>
			<a href="http://www.massidea.org/blog/?page_id=71">
			<?php echo __('index-contact'); ?></a>
		</li>
		<li>
			<a href="http://www.massidea.org/blog/?page_id=74">
			<?php echo __('index-development'); ?></a>
		</li>
		<li>
			<a href="#" onclick="popup('popup_terms_'); return false;">
			<?php echo __('index-service-agreement'); ?></a>
 		</li>
		<li>
			<a href="#" onclick="popup('popup_privacy_'); return false;">
			<?php echo __('index-register-description'); ?></a>
		</li>
	</ul>
</div>

                <div class="dot-line-720 clear"></div>
                <div class="left">
                    <p><?php echo $this->translate('index-funded'); ?></p>
                    <a href="http://www.rakennerahastot.fi/rakennerahastot/<?php echo $this->language; ?>/index.jsp">
                        <img src="<?php echo $this->baseUrl('/images/footer1.png'); ?>" alt="Footer" />
                    </a>
                </div>
                <div class="right">
                    <p><?php echo $this->translate('index-coordinator'); ?></p>
                    <?php
                        // This entire block should be done somewhere else than here
                    $uniUrl['cop'] = 'http://www.cop.fi/';
                    $uniUrl['hamk'] = 'http://www.hamk.fi/';
                    $uniUrl['tkk'] = 'http://www.tkk.fi/';
                    $uniUrl['humak'] = 'http://www.humak.fi/';
                    $uniUrl['tokem'] = 'http://www.tokem.fi/';
                    $uniUrl['kyamk'] = 'http://www.kyamk.fi/';
                    $uniUrl['laurea'] = 'http://www.laurea.fi/';
                    $uniUrl['piramk'] = 'http://www.tamk.fi/';
                    $uniUrl['ramk'] = 'http://www.ramk.fi/';
                    $uniUrl['samk'] = 'http://www.samk.fi/';
                    $uniUrl['tamk'] = 'http://www.tamk.fi/';
                    $uniUrl['tse'] = 'http://www.tse.fi/';

                    if ($this->language == 'en') {
                        $uniUrl['laurea'] = 'http://www.laurea.fi/internet/en/index.jsp';
                    }
                    ?>
                    <a href="<?php echo $uniUrl['laurea']; ?>">
                        <img src="<?php echo $this->baseUrl('/images/laurea.png'); ?>" alt="Laurea" />
                    </a>
                    <p><?php echo $this->translate('index-group'); ?></p>
                    <select id="project_groups">
                        <option value="0">Select partner university</option>
                        <option value="<?php echo $uniUrl['cop']; ?>">
                            Central Ostrobothnia University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['hamk']; ?>">
                            HAMK University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['tkk']; ?>">
                            Helsinki University of Technology
                        </option>
                        <option value="<?php echo $uniUrl['humak']; ?>">
                            HUMAK University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['tokem']; ?>">
                            Kemi-Tornio University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['kyamk']; ?>">
                            Kymenlaakso University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['laurea']; ?>">
                            Laurea University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['piramk']; ?>">
                            PIRAMK University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['ramk']; ?>">
                            Rovaniemi University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['samk']; ?>">
                            Satakunta University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['tamk']; ?>">
                            TAMK University of Applied Sciences
                        </option>
                        <option value="<?php echo $uniUrl['tse']; ?>">
                            Finland Future Research Center
                        </option>
                    </select>
                </div>
                <div class="dot-line-720 clear"></div>
                */ ?>