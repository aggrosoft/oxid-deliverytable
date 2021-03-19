<?php

namespace Aggrosoft\DeliveryTable\Core;

class DeliveryTableViewConfig extends DeliveryTableViewConfig_parent
{
    public function getDeliveryTable()
    {
        $oCountryList = oxNew(\OxidEsales\Eshop\Application\Model\CountryList::class);
        $oCountryList->loadActiveCountries();

        foreach ($oCountryList as $oCountry)
        {
            $oDelSetList = oxNew(\OxidEsales\Eshop\Application\Model\DeliverySetList::class);
            $oDelSetList = $oDelSetList->getDeliverySetList(null, $oCountry->getId());
        }

        $oDeliverySetList = oxNew(\OxidEsales\Eshop\Application\Model\DeliverySetList::class);
        $oDeliverySetList->selectString("select * from oxdeliveryset where oxactive = 1");
        $result = array();
        foreach ($oDeliverySetList as $oDeliverySet)
        {

            $obj = new stdClass();
            $obj->delset = $oDeliverySet;
            $obj->deliveries = array();
            $oDeliveryList = oxNew(\OxidEsales\Eshop\Application\Model\DeliveryList::class);
            $oDeliveryList->selectString("select * from oxdelivery where oxactive=1 and  oxid in (select oxdelid from oxdel2delset where oxdelsetid='".$oDeliverySet->getId()."')");

            foreach ($oDeliveryList as $oDelivery)
            {
                $oCountryList = oxNew(\OxidEsales\Eshop\Application\Model\CountryList::class);
                $oCountryList->selectString("select * from oxcountry where oxid in (select OXOBJECTID from oxobject2delivery where oxobject2delivery.oxdeliveryid='".$oDelivery->getId()."' 
					and oxobject2delivery.oxtype='oxcountry')");
                $delObj = new stdClass();
                $delObj->delivery = $oDelivery;
                $delObj->countries = $oCountryList;
                $obj->deliveries[] = $delObj;
            }
            $result[] = $obj;
        }

        return $result;
    }
}