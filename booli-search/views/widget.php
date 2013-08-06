<ul>
	<?php foreach ($result->listings as $listing): ?>
		<li>
			<div>
				<?php if (!empty($listing->thumb)): ?>
					<a href="<?php echo $listing->url ?>/bilder"><img width="65" height="43" src="http://i.bcdn.se/cache/<?php echo $listing->thumb->id ?>_65x43.jpg"></a>
				<?php endif ?>
				<h2>
					<a href="<?php echo $listing->url ?>">
						<?php echo $listing->location->address->streetAddress ?>
						<?php echo isset($listing->location->namedAreas[0]) ? ", {$listing->location->namedAreas[0]}" : "" ?>
					</a>
				</h2>
				<p>
					<?php echo $listing->objectType ?><?php echo isset($listing->listPrice) ? ", {$listing->listPrice} kr" : "" ?><?php echo isset($listing->livingArea) ? ", {$listing->livingArea} m²" : "" ?><?php echo isset($listing->rooms) ? ", {$listing->rooms} rum" : "" ?>
			</div>
		</li>
	<?php endforeach ?>
</ul>
