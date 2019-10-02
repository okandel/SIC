var mongoose = require('mongoose');
var mongoose_sequence = require('mongoose-sequence')(mongoose);
require('mongoose-double')(mongoose);
var SchemaTypes = mongoose.Schema.Types;

var locationSchema = new mongoose.Schema({
    id: Number,
    EmpId: Number,
    lat: {
        type: SchemaTypes.Double,
        required: true
    },
    lng: {
        type: SchemaTypes.Double,
        required: true
    },
    alt: SchemaTypes.Double,
    speed: SchemaTypes.Double,
    bearing_heading: SchemaTypes.Double,
});

locationSchema.plugin(mongoose_sequence, {
    inc_field: 'id'
});
mongoose.model('locations', locationSchema);