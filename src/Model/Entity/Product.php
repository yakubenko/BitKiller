<?php
namespace BitKiller\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property int $category_id
 * @property int $vendor_id
 * @property int $parent_id
 * @property string $title
 * @property string $slug
 * @property string $extcode
 * @property string $type
 * @property int $active
 * @property string $updated
 * @property string $created
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Product $parent_product
 * @property \App\Model\Entity\Price[] $prices
 * @property \App\Model\Entity\Product[] $child_products
 */
class Product extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
