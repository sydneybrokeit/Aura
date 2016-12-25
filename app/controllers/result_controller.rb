class ResultController < ApplicationController
  def load
    @data = getData(params["sku"])
  end
  def getData(mainSku)
    Sku.where("sku")
        return JSON.parse(sku.json)
      else
        return "Sorry, that SKU could not be found " + mainSku + sku.json
    end
  end
end
end
